<?php

declare(strict_types=1);

namespace T3Dev\Cfajob\Controller;

use TYPO3\CMS\Extbase\Annotation as Extbase;

use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use T3Dev\Cfajob\Php\FindUser;
use T3Dev\Cfajob\Domain\Model\FrontendUser;
use T3Dev\Cfajob\Utility\FileUtility;
use T3Dev\Cfajob\Utility\UserUtility;
use T3Dev\Cfajob\Domain\Model\Location;
use T3Dev\Cfajob\Domain\Model\Diploma;
use T3Dev\Cfajob\Domain\Model\Experience;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use T3Dev\Cfajob\Utility\MailUtility;
use T3Dev\Cfajob\Domain\Repository\CartRepository;
use T3Dev\Cfajob\Domain\Model\CartItem;
use T3Dev\Cfajob\Domain\Model\Cart;
use T3Dev\Cfajob\Utility\HashUtility;
use T3Dev\Cfajob\Domain\Model\FileReference;
use T3Dev\Cfajob\Service\Recaptcha;
use \T3Dev\Cfajob\Domain\Model\FrontendUserGroup;

/***
 *
 * This file is part of the "CFA Job" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020 Dmitry Vasilev <dmitry@t3dev.ru>, T3Dev
 *
 ***/
/**
 * FrontendUserController
 */
class FrontendUserController extends AbstractController
{
    const EXT_KEY = 'cfajob';

    /**
     * @var int
     */
    protected $storagePid;

    /**
     * @var int
     */
    protected $userResumePid;

    /**
     * @var int
     */
    protected $currentPid;

    /**
     * cartRepository
     *
     * @var CartRepository
     */
    protected $cartRepository = null;

    /**
     * @param CartRepository $cartRepository
     */
    public function injectCartRepository(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    /**
     * Initialize methods and form data
     *
     * @return
     */
    public function __construct()
    {
        $config = $this->getConfiguration();
        $this->userResumePid = (int)$config['userResumePid'];
        $this->storagePid = (int)$config['storagePid'];
        $this->currentPid = (int)$GLOBALS['TSFE']->id;
    }

    /**
     * Load JS Libraries and Code
     */
    private function loadSourcesListView()
    {

        /** @var \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer */
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $extRelPath = PathUtility::stripPathSitePrefix(ExtensionManagementUtility::extPath(self::EXT_KEY));
        // Include js files
        $pageRenderer->addJsFile($extRelPath . "Resources/Public/Javascript/JqueryTimeago/jquery.timeago.js", 'text/javascript', false, false, '', true);
        $pageRenderer->addJsFile($extRelPath . "Resources/Public/Javascript/JqueryTimeago/locales/jquery.timeago.fr.js", 'text/javascript', false, false, '', true);
    }

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        // Load custom js
        $this->loadSourcesListView();
        $positions = $this->positionRepository->findAll();
        $studentGroup = $this->frontendUserGroupRepository->findByUid($this->settings['groups']['diplome']);

        $city = $_POST['tx_cfajob_cfajob']['city'];
        $zip = $_POST['tx_cfajob_cfajob']['zip'];

        if (!empty($_POST)) {
            if ($city !=='') {
                $cityObj = $this->locationRepository->findOneByName($city);
                if ($cityObj instanceof \T3Dev\Cfajob\Domain\Model\Location) {
                    $students = $this->frontendUserRepository->findByLocation($cityObj);
                    $this->view->assign('city', $city);
                }
            }
            if ($zip !=='') {
                $students = $this->frontendUserRepository->findByZip($zip);
                $this->view->assign('zip', $zip);
            }

            // If isset some values for filter
            if (is_array($_POST['checklist'])) {
                $checklistArr = $_POST['checklist'];
                $students = $this->frontendUserRepository->findByPositionsAndGroup($checklistArr, $studentGroup);

                if ($city !=='') {
                    $cityObj = $this->locationRepository->findOneByName($city);
                    if ($cityObj instanceof \T3Dev\Cfajob\Domain\Model\Location) {
                        $students = $this->frontendUserRepository->findByTypeAndCity($checklistArr, $cityObj, $studentGroup);
                    }
                }
                if ($zip !=='') {
                    $students = $this->frontendUserRepository->findByTypeAndZip($checklistArr, $cityObj, $studentGroup);
                }
                if ($city !=='' && $zip !=='') {
                    $students = $this->frontendUserRepository->findByTypeAndCityAndZip($checklistArr, $cityObj, $zip, $studentGroup);
                }
            }
        } else {
            $students = $this->frontendUserRepository->findByUsergroup($studentGroup);
        }

        // Memorized user
        $carts = $this->cartRepository->findAll();
        foreach ($carts as $cart) {
            foreach ($cart->getItems() as $items) {
                $cartItems[] = $items;
            }
        }

        $this->view->assign('students', $students);
        $this->view->assign('positions', $positions);
        $this->view->assign('checklistArr', $checklistArr);
        //$this->view->assign('carts', $carts);
        $this->view->assign('cartItems', $cartItems);
    }

    /**
     * action addr product
     *
     * @param integer $cartNumber
     * @return void
     */
    public function addToCartAction($cartNumber = 0)
    {

        // add to cart functions
        if ($this->request->hasArgument('item')) {
            $identity = $this->request->getArgument('item');
            $variant = $this->frontendUserRepository->findByUid($identity);

            if ($variant) {
                $cart = $this->getCart();

                if ($cart instanceof \T3Dev\Cfajob\Domain\Model\Cart) {
                    $uid = $variant->getUid();
                    if ($cartItem = $cart->getItem($uid)) {
                        // If need to set quantity
                        //$cartItem->setQuantity($quantity);
                    } else {
                        /** @var CartItem  $newCartItem */
                        $newCartItem = GeneralUtility::makeInstance(CartItem::class);
                        $newCartItem->setUid($uid);
                        // If need to set quantity
                        //$newCartItem->setQuantity($quantity);
                        $cart->addItem($newCartItem);
                    }

                    $this->cartRepository->setCart($cart, $cartNumber);
                    //$this->persistenceManager->persistAll();
                }
            }
        }
        // set redirect
        $currentPid = $GLOBALS['TSFE']->id;
        $this->redirectToPage($currentPid);
    }

    /**
     * action remove cart item
     *
     * @param integer $item
     * @param integer $cartNumber
     *
     * @return void
     */
    public function removeFromCartAction($item, $cartNumber = 0)
    {
        $cart = $this->getCart($cartNumber);
        $cart->removeItem($item);
        $this->cartRepository->setCart($cart, $cartNumber);
        $this->persistenceManager->persistAll();

        $currentPid = $GLOBALS['TSFE']->id;
        $this->redirectToPage($currentPid);
    }


    /**
     * action addr product
     *
     * @param integer $cartNumber
     *
     * @return void
     */
    protected function getCart($cartNumber = 0)
    {
        $carts = $this->cartRepository->findAll();
        $i = 0;
        foreach ($carts as $cart) {
            if ($i == $cartNumber) {
                break;
            }
            $i++;
        }
        if (!$cart) {
            /** @var Cart  $cart */
            $cart = GeneralUtility::makeInstance(Cart::class);
            $cart->setNumber(time());
        }
        return $cart;
    }


    /**
     * action show
     *
     * @param \T3Dev\Cfajob\Domain\Model\FrontendUser $user
     * @return void
     */
    public function showAction(\T3Dev\Cfajob\Domain\Model\FrontendUser $user)
    {
        $this->view->assign('user', $user);
    }

    public function newFilesPrepare($newFiles=0)
    {
        $filesArray = [];
        if ($newFiles > 0) {
            for ($i = 0; $i < $newFiles; $i++) {
                $filesArray[] = '';
            }
        }
        $this->view->assign('newFiles', $filesArray);
    }

    public function newCvfilesPrepare($newCvfiles=0)
    {
        $cvFilesArray = [];
        if ($newCvfiles > 0) {
            for ($i = 0; $i < $newCvfiles; $i++) {
                $cvFilesArray[] = '';
            }
        }
        $this->view->assign('newCvfiles', $cvFilesArray);
    }

    /**
     * action new
     *
     * @return string
     */
    public function newAction()
    {
        //$currentLoggedInUser = $this->frontendUserRepository->findByUid(intval($GLOBALS['TSFE']->fe_user->user['uid']));
        //$this->view->assign('currentLoggedInUser', $currentLoggedInUser);

        // Re-captcha to form
        $config = $this->getConfiguration();
        $this->view->assign('useRecaptcha', $config['use_recaptcha']);
        $this->view->assign('clientKey', $config['recaptcha_client_key']);

        $positions = $this->positionRepository->findAll();
        $this->view->assign('positions', $positions);

        $args = $this->request->getArguments();
        $success = $args['success'];

        /** @var FileUtility $fileUtility */
        // Crate temp directory to upload files
        $fileUtility = GeneralUtility::makeInstance(FileUtility::class);
        $confTargetFolder = $this->settings['upload']['temp'];
        $fileUtility->checkUploadDirectory($confTargetFolder);

        $newFiles = $this->settings['upload']['maxFiles'];
        $this->newFilesPrepare($newFiles);

        $newCvFiles = $this->settings['upload']['maxFiles'];
        $this->newCvfilesPrepare($newCvFiles);

        // Check if user already exist
        // ToDo: transfer to js script parameter to display in ajax
        if (!empty($_POST["email"])) {
            $user = $this->frontendUserRepository->findOneByEmail($_POST["email"]);
            if ($user > 0) {
                //return '<span class="status-not-available"> Email Not Available</span>';
                //echo "<span class='status-not-available'> Email Not Available</span>";
            } else {
                //echo "<span class='status-available'> Username Available.</span>";
                //return '<span class="status-available"> Email Available</span>';
            }
        }
    }

    /**
     * action create front-end user
     *
     * @param FrontendUser $newFrontendUser
     * @return void
     */
    public function createAction(FrontendUser $newFrontendUser)
    {
        $newUserFormPage = $this->settings['user']['new']['formPage'];
        $usergroup = $this->settings['groups']['diplome'];
        $usergroupObj = $this->frontendUserGroupRepository->findByUid($usergroup);

        // RECAPTCHA validation
        $recaptcha = $_POST['g-recaptcha-response'];
        $captchaObj = GeneralUtility::makeInstance(Recaptcha::class);
        $response = $captchaObj->verifyResponse($recaptcha);

        $config = $this->getConfiguration();
        if ($config['use_recaptcha'] == '1') {
            if (isset($response['success']) and $response['success'] != true) {
                $this->flashMessageService('tx_cfajob.message.error_has_occurred', 'errorStatus', 'ERROR');
                $this->redirect('new', 'FrontendUser', null, ['success' => '-1'], $newUserFormPage);
                exit;
            }
        }

        // Use email as username
        $email = $_POST['tx_cfajob_cfajob']['newFrontendUser']['email'];
        $email = trim($email);
        //$user = $this->frontendUserRepository->findOneByUsername($username);
        $user = $this->frontendUserRepository->findOneByEmailAndUsergroup($email, $usergroupObj);

        // If user with this email doesn't exist than create a new user
        if (!($user instanceof FrontendUser)) {
            // Create new user and set properties
            $newFrontendUser->setUsername($email);
            $newFrontendUser->setPassword($this->settings['user']['new']['defaultPassword']);
            $newFrontendUser->setPid($this->userResumePid);
            $newFrontendUser->setDisable('1');
            $newFrontendUser->setUsergroup($usergroup);
            $this->frontendUserRepository->add($newFrontendUser);

            // Convert password to hash
            $hashMethod = UserUtility::getHashMethod();
            UserUtility::convertPassword($newFrontendUser, $hashMethod);

            // Set group
            //if ($usergroupObj instanceof FrontendUserGroup) {
            //    $newFrontendUser->setUsergroup($usergroupObj);
            //}

            // Set city
            $locationObj = $this->setLocation();
            if ($locationObj instanceof Location) {
                $newFrontendUser->setLocation($locationObj);
            }

            // Get user directory for upload
            $directory = $this->userDirectory($newFrontendUser);

            // Upload files
            $this->setUploadFile($newFrontendUser, 'photo', $directory);

            // Upload cv file
            $this->setUploadFile($newFrontendUser, 'cvfile', $directory);

            // Set relation diplomes
            if (isset($_POST['diplome']['1']['name'])) {
                $diplomes = $this->setDiplomes($newFrontendUser);
            }

            // Set relation experience
            if (isset($_POST['experience']['1']['employer'])) {
                $experiences = $this->setExperience($newFrontendUser);
            }

            // Persist all before send email
            $this->persistenceManager->persistAll();

            // Atach user photo
            if ($newFrontendUser->getPhoto()) {
                $filename = $newFrontendUser->getPhoto()->getOriginalResource()->getPublicUrl();
            } else {
                $filename = '';
            }

            // Attach cv file
            if ($newFrontendUser->getCvfile()) {
                $cvFileName = $newFrontendUser->getCvfile()->getOriginalResource()->getPublicUrl();
            } else {
                $cvFileName = '';
            }

            //Send email
            $userListPage = $this->settings['userListPage'];
            $mailTemplate = 'MailToAdminNewStudent';
            $hash = HashUtility::createHashForUser($newFrontendUser);

            $subject = LocalizationUtility::translate('tx_cfajob.new_user_subject', 'cfajob');
            $variables = ['user' => $newFrontendUser, 'experiences' => $experiences, 'diplomes' => $diplomes, 'hash' => $hash, 'userListPage' => $userListPage];
            $sender = $this->settings['offer']['mail']['defaultSender'];
            $emails = preg_split('/[;,]/', $this->settings['offer']['mail']['reciever']);
            foreach ($emails as $email) {
                $recipients[] = trim($email);
            }

            // Make instanse for send mail
            $mailUtility = GeneralUtility::makeInstance(MailUtility::class);
            $mailUtility->sendEmail($mailTemplate, $recipients, $sender, $subject, $variables, $filename, $cvFileName);

            $this->flashMessageService('tx_cfajob.message.user_created', 'okStatus', 'OK');
            $this->frontendUserRepository->add($newFrontendUser);
            $this->redirect('new', 'FrontendUser', null, null, $this->settings['redirectPage']);
        } else {

            // Update existing user and set properties
            // Convert password to hash
            $user->setPassword($this->settings['user']['new']['defaultPassword']);
            $hashMethod = UserUtility::getHashMethod();
            UserUtility::convertPassword($user, $hashMethod);

            // Set city
            $locationObj = $this->setLocation();
            if ($locationObj instanceof Location) {
                $user->setLocation($locationObj);
            }

            // Set properties from POST array
            $post = $_POST['tx_cfajob_cfajob']['newFrontendUser'];
            if ($post['firstName'] !=='') {
                $user->setFirstName($post['firstName']);
            }
            if ($post['lastName'] !=='') {
                $user->setLastName($post['lastName']);
            }
            if ($post['about'] !=='') {
                $user->setAbout($post['about']);
            }
            if ($post['titleCV'] !=='') {
                $user->setTitleCV($post['titleCV']);
            }
            if ($post['position'] !=='') {
                $poistion = $this->positionRepository->findOneByUid($post['position']);
                $user->setPosition($poistion);
            }

            // Get user directory for upload
            $directory = $this->userDirectory($user);

            // Remove files if isset another
            $files = $_FILES['tx_cfajob_cfajob']['name'];
            if ($files['photo']['0'] !=='' && $user->getPhoto()) {
                foreach ($user->getPhoto() as $photo) {
                    $this->frontendUserRepository->removeFileReference($photo->getUid());
                }
            }
            if ($files['cvfile']['0'] !=='' && $user->getCvfile()) {
                foreach ($user->getCvfile() as $cvfile) {
                    $this->frontendUserRepository->removeFileReference($cvfile->getUid());
                }
            }
            // Upload files
            $this->setUploadFile($user, 'photo', $directory);
            // Upload cv file
            $this->setUploadFile($user, 'cvfile', $directory);

            if (isset($_POST['diplome']['1']['name'])) {
                // First remove relation diplomes if set new
                if ($user->getDiploma()) {
                    foreach ($user->getDiploma() as $diploma) {
                        $user->removeDiploma($diploma);
                    }
                }
                // Set relation diplomes
                $diplomes = $this->setDiplomes($user);
            }

            if (isset($_POST['experience']['1']['employer'])) {
                // First remove relation experience if set new
                if ($user->getExperience()) {
                    foreach ($user->getExperience() as $experience) {
                        $user->removeExperience($experience);
                    }
                }
                // Set relation experience
                $experiences = $this->setExperience($user);
            }

            // Persist all before send email
            $this->persistenceManager->persistAll();

            // Atach user photo
            if ($user->getPhoto()) {
                $filename = $user->getPhoto()->getOriginalResource()->getPublicUrl();
            } else {
                $filename = '';
            }

            // Attach cv file
            if ($user->getCvfile()) {
                $cvFileName = $user->getCvfile()->getOriginalResource()->getPublicUrl();
            } else {
                $cvFileName = '';
            }

            //Send email
            $userListPage = $this->settings['userListPage'];
            $mailTemplate = 'MailToAdminUpdateStudent';
            $hash = HashUtility::createHashForUser($user);

            $subject = LocalizationUtility::translate('tx_cfajob.update_user_subject', 'cfajob');
            $variables = ['user' => $user, 'experiences' => $experiences, 'diplomes' => $diplomes, 'hash' => $hash, 'userListPage' => $userListPage];
            $sender = $this->settings['offer']['mail']['defaultSender'];
            $emails = preg_split('/[;,]/', $this->settings['offer']['mail']['reciever']);
            foreach ($emails as $email) {
                $recipients[] = trim($email);
            }

            // Make instanse for send mail
            $mailUtility = GeneralUtility::makeInstance(MailUtility::class);
            $mailUtility->sendEmail($mailTemplate, $recipients, $sender, $subject, $variables, $filename, $cvFileName);

            $this->flashMessageService('tx_cfajob.message.user_updated', 'okStatus', 'OK');
            $this->frontendUserRepository->update($user);
            $this->redirect('new', 'FrontendUser', 'Cfajob', null, $this->settings['redirectPage']);
        }
    }

    /**
     * Returns the diplomes
     *
     * @return array $diplomes
     */
    private function setDiplomes($newFrontendUser)
    {
        $return = [];
        $diplomes = $_POST['diplome'];
        foreach ($diplomes as $diplome) {
            //if ($diplome['name'] !== '' && $diplome['diplome'] !== '' && $diplome['dateStart'] !== '' && $diplome['dateEnd'] !== '')
            if ($diplome['name'] !== '') {

                /** @var Diploma $diplomeObject */
                $diplomeObject = GeneralUtility::makeInstance(Diploma::class);
                $diplomeObject->setPid($this->storagePid);
                $diplomeObject->setUser($newFrontendUser);
                $diplomeObject->setName($diplome['name']);
                $diplomeObject->setDiploma($diplome['diplome']);
                $diplomeDateStart = $this->getDateObj($diplome['dateStart']);
                $diplomeObject->setStartYear($diplomeDateStart);
                $diplomeDateEnd = $this->getDateObj($diplome['dateEnd']);
                $diplomeObject->setEndYear($diplomeDateEnd);
                $diplomeObject->setDescription($diplome['description']);
                $this->diplomaRepository->add($diplomeObject);
                $return[] = $diplomeObject;
            }
        }

        return $return;
    }

    /**
     * Returns the experiences
     *
     * @return array $experiences
     */
    private function setExperience($newFrontendUser)
    {
        $return = [];
        $experiences = $_POST['experience'];
        foreach ($experiences as $experience) {
            //if ($experience['employer'] !=='' && $experience['posteExp'] !=='' && $experience['dateStartExp'] !=='' && $experience['dateEndExp'] !=='')
            if ($experience['employer'] !=='') {

                /** @var Experience $experienceObject */
                $experienceObject = GeneralUtility::makeInstance(Experience::class);
                $experienceObject->setPid($this->storagePid);
                $experienceObject->setUser($newFrontendUser);
                $experienceObject->setEmployeur($experience['employer']);
                $experienceObject->setPosition($experience['posteExp']);
                $dateStartExp = $this->getDateObj($experience['dateStartExp']);
                $experienceObject->setStartYear($dateStartExp);
                $dateEndExp = $this->getDateObj($experience['dateEndExp']);
                $experienceObject->setEndYear($dateEndExp);
                $experienceObject->setDescription($experience['descriptionExp']);
                $this->experienceRepository->add($experienceObject);
                $return[] = $experienceObject;
            }
        }

        return $return;
    }

    private function setLocation()
    {
        $city = $_POST['location'];
        $city = trim($city);
        $location = $this->locationRepository->findOneByName($city);
        if (!($location instanceof Location)) {
            // Create new city
            $cityObj = GeneralUtility::makeInstance(Location::class);
            $cityObj->setPid($this->storagePid);
            $cityObj->setName($city);
            $this->locationRepository->add($cityObj);
            $this->persistenceManager->persistAll();
            $locationObj = $cityObj;
        } else {
            // Set existing city
            $locationObj = $location;
        }

        return $locationObj;
    }


    /**
     * action edit
     *
     * @param \T3Dev\Cfajob\Domain\Model\FrontendUser $frontendUser
     * @Extbase\IgnoreValidation("frontendUser")
     * @return void
     */
    public function editAction(\T3Dev\Cfajob\Domain\Model\FrontendUser $frontendUser)
    {
        $this->view->assign('frontendUser', $frontendUser);
    }

    /**
     * action user profile
     *
     * @return void
     */
    public function profileAction()
    {
        $frontendUser = $this->frontendUserRepository->findByUid(intval($GLOBALS['TSFE']->fe_user->user['uid']));
        if ($frontendUser instanceof FrontendUser) {
            if ($this->accessService->isAccessAllowed($frontendUser)) {
                // Access allowed
                $cities = $this->locationRepository->findAll();
                $positions = $this->positionRepository->findAll();

                $newFiles = $this->settings['upload']['maxFiles'];
                $this->newFilesPrepare($newFiles);
                $newCvFiles = $this->settings['upload']['maxFiles'];
                $this->newCvfilesPrepare($newCvFiles);

                $this->view->assign('frontendUser', $frontendUser);
                $this->view->assign('cities', $cities);
                $this->view->assign('positions', $positions);
            } else {
                $this->redirectToPage($this->currentPid);
                $this->flashMessageService('tx_cfajob.message.incorrect_login', 'errorStatus', 'ERROR');
            }
        } else {
            $this->flashMessageService('tx_cfajob.message.to_fill_form_please_login', 'errorStatus', 'ERROR');
        }
    }

    /**
     * action update
     *
     * @param FrontendUser $frontendUser
     * @return void
     */
    public function updateProfileAction(FrontendUser $frontendUser)
    {

        // Get user directory for upload
        $directory = $this->userDirectory($frontendUser);
        // Update password if changed
        $password = $_POST['tx_cfajob_cfajob']['password'];
        if ($password !== '') {
            if (strlen($password) < $this->settings['validation']['minPasswordLenght']) {
                $this->flashMessageService('tx_cfajob.short_password', 'errorStatus', 'ERROR');
                $this->redirectToPage($this->currentPid);
            }

            $frontendUser->setPassword($password);
            // Convert password to hash
            $hashMethod = UserUtility::getHashMethod();
            UserUtility::convertPassword($frontendUser, $hashMethod);
        }

        // Remove image
        $removeImage = $_POST['tx_cfajob_cfajob']['photo']['removeImage'];
        if ($removeImage == 1 && $frontendUser->getPhoto()) {
            foreach ($frontendUser->getPhoto() as $photo) {
                //$frontendUser->removePhoto($photo);
                //\TYPO3\CMS\Core\Utility\DebugUtility::debug($newFile);
                // We get strange result if after remove image by repository (detach method) and after upload a new image, we get both images.
                // So remove reference only from table sys_file_reference
                // And not from table sys_file, because it is possible the file is using in other tables
                $this->frontendUserRepository->removeFileReference($photo->getUid());
            }
        }
        // Upload new image
        $newImage = $_FILES['tx_cfajob_cfajob']['name']['photo']['newImage'];
        if ($newImage !=='') {
            $this->setUploadFile($frontendUser, 'photo', $directory);
        }

        // Remove file
        $removeFile = $_POST['tx_cfajob_cfajob']['cvfile']['removeFile'];
        if ($removeFile == 1 && $frontendUser->getCvfile()) {
            foreach ($frontendUser->getCvfile() as $cvfile) {
                $this->frontendUserRepository->removeFileReference($cvfile->getUid());
            }
        }
        // Upload new file
        $newFile = $_FILES['tx_cfajob_cfajob']['name']['cvfile']['newFile'];
        if ($newFile !=='') {
            $this->uploadFile($frontendUser, 'cvfile', 'setCvfile', $directory);
        }

        // Set city
        $locationObj = $this->setLocation();
        if ($locationObj instanceof Location) {
            $frontendUser->setLocation($locationObj);
        }

        $this->flashMessageService('tx_cfajob.profile_updated', 'okStatus', 'OK');
        $this->frontendUserRepository->update($frontendUser);
        $this->redirectToPage($this->currentPid);
    }

    /**
     * function eventDirectory
     *
     * @param FrontendUser $frontendUser
     * @return \String
     */
    public function userDirectory(FrontendUser $frontendUser)
    {
        $directory = '/'. $frontendUser->getUsername();
        $directory = str_replace('@', '_at_', $directory);
        $directory = str_replace('.', '_', $directory);
        return $directory;
    }

    /**
     * action enable user
     *
     * @param string $hash
     * @Extbase\IgnoreValidation("user")
     * @return void
     */
    public function enableUserAction($hash)
    {
        if ($this->request->hasArgument('user')) {
            $userUid = $this->request->getArgument('user');
            $user = $this->frontendUserRepository->findHiddenByUid($userUid);

            if (HashUtility::validUserHash($hash, $user)) {
                $this->frontendUserRepository->setEnabled($userUid);
                $this->persistenceManager->persistAll();

                $mailTemplate = 'MailToAdminStudentEnabled';
                $variables = ['user' => $user];
                $subject = LocalizationUtility::translate('tx_cfajob.user_enabled_subject', 'cfajob');
                $sender = $this->settings['user']['mail']['defaultSender'];
                //$receiver = $this->settings['user']['mail']['reciever'];
                $emails = preg_split('/[;,]/', $this->settings['offer']['mail']['reciever']);
                foreach ($emails as $email) {
                    $recipients[] = trim($email);
                }

                // Make instanse for send mail
                $mailUtility = GeneralUtility::makeInstance(MailUtility::class);
                $mailUtility->sendEmail($mailTemplate, $recipients, $sender, $subject, $variables);

                $this->flashMessageService('tx_cfajob.message.user_enabled', 'okStatus', 'OK');
            } else {
                $this->flashMessageService('tx_cfajob.message.incorrect_link', 'errorStatus', 'ERROR');
            }
        }

        $this->redirectToPage($this->settings['userListPage']);
    }

    /**
     * action delete user
     *
     * @param string $hash
     * @Extbase\IgnoreValidation("user")
     * @return void
     */
    public function deleteUserAction(string $hash)
    {
        if ($this->request->hasArgument('user')) {
            $userUid = $this->request->getArgument('user');
            $user = $this->frontendUserRepository->findHiddenByUid($userUid);

            if (HashUtility::validUserHash($hash, $user)) {
                $this->flashMessageService('tx_cfajob.message.user_deleted', 'okStatus', 'OK');
                $this->frontendUserRepository->remove($user);

                $mailTemplate = 'MailToAdminStudentDeleted';
                $variables = ['user' => $user];
                $subject = LocalizationUtility::translate('tx_cfajob.user_deleted_subject', 'cfajob');
                $sender = $this->settings['user']['mail']['defaultSender'];
                //$receiver = $this->settings['user']['mail']['reciever'];
                $emails = preg_split('/[;,]/', $this->settings['offer']['mail']['reciever']);
                foreach ($emails as $email) {
                    $recipients[] = trim($email);
                }

                // Make instanse for send mail
                $mailUtility = GeneralUtility::makeInstance(MailUtility::class);
                $mailUtility->sendEmail($mailTemplate, $recipients, $sender, $subject, $variables);
            } else {
                $this->flashMessageService('tx_cfajob.message.incorrect_link', 'errorStatus', 'ERROR');
            }
        }
        
        $this->redirectToPage($this->settings['userListPage']);
    }
}
