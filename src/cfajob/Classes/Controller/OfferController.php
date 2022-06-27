<?php
namespace T3Dev\Cfajob\Controller;

use T3Dev\Cfajob\Domain\Model\Location;
use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use T3Dev\Cfajob\Domain\Model\Offer;
use T3Dev\Cfajob\Utility\MailUtility;
use T3Dev\Cfajob\Utility\HashUtility;
use T3Dev\Cfajob\Service\Recaptcha;
use T3Dev\Cfajob\Domain\Model\FrontendUser;
use T3Dev\Cfajob\Domain\Model\FrontendUserGroup;
use T3Dev\Cfajob\Utility\UserUtility;
use TYPO3\CMS\Core\Pagination\ArrayPaginator;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use T3Dev\Cfajob\Utility\PaginationUtility;

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
 * OfferController
 */
class OfferController extends AbstractController
{

    /**
     * @var int
     */
    protected $storagePid;

    /**
     * @var int
     */
    protected $userOfferPid;

    /**
     * @var int
     */
    protected $currentPid;

    /**
     * Initialize methods and form data
     *
     * @return
     */
    public function __construct()
    {
        $config = $this->getConfiguration();
        $this->userOfferPid = (int)$config['userOfferPid'];
        $this->storagePid = (int)$config['storagePid'];
        $this->currentPid = (int)$GLOBALS['TSFE']->id;
    }

    /**
     * Load JS Libraries and Code
     */
    private function loadSourcesListView()
    {
        $extensionKey = 'cfajob';

        /** @var \TYPO3\CMS\Core\Page\PageRenderer $pageRenderer */
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $extRelPath = PathUtility::stripPathSitePrefix(ExtensionManagementUtility::extPath($extensionKey));
        // Include js files
        $pageRenderer->addJsFile($extRelPath . "Resources/Public/Javascript/JqueryTimeago/jquery.timeago.js", 'text/javascript', false, false, '', true);
        $pageRenderer->addJsFile($extRelPath . "Resources/Public/Javascript/JqueryTimeago/locales/jquery.timeago.fr.js", 'text/javascript', false, false, '', true);
    }

    /**
     * action list
     *
     * @param int $currentPage
     * @return void
     */
    public function listAction(int $currentPage = 1)
    {
        $this->loadSourcesListView();
        $cityStr = $_POST['tx_cfajob_cfajob']['city'];
        $zip = $_POST['tx_cfajob_cfajob']['zip'];
        $checklistArr = $_POST['checklist'];

        // Overrite variables for get pagination
        if ($this->request->hasArgument('zip')) {
            $zip = $this->request->getArgument('zip');
        }
        if ($this->request->hasArgument('city')) {
            $cityStr = $this->request->getArgument('city');
        }
        if ($this->request->hasArgument('checklistArr')) {
            $checklistArr = $this->request->getArgument('checklistArr');
        }

        // Find by filter
        if (!empty($_POST)) {
            $offers = $this->offerRepository->findByParams($zip, $cityStr, $checklistArr);
            $currentPage = 1;
        } elseif ($zip || $cityStr || $checklistArr) {
            $offers = $this->offerRepository->findByParams($zip, $cityStr, $checklistArr);
        } else {
            $offers = $this->offerRepository->findAll();
        }
        foreach ($offers as $offer) {
            $offerIds[] = $offer->getUid();
        }

        if (is_array($offerIds)) {
            $itemsPerPage = $this->settings['pagination']['itemsPerPage'];
            $arrayPaginator = new ArrayPaginator($offerIds, $currentPage, $itemsPerPage);
            //$pagination = new SimplePagination($arrayPaginator);
            $pagination = new PaginationUtility($arrayPaginator);
            foreach ($arrayPaginator->getPaginatedItems() as $paginatedItemId) {
                $paginatedItems[] = $this->offerRepository->findByUid($paginatedItemId);
            }
            $pages = range(1, $pagination->getLastPageNumber());
            $this->view->assignMultiple(
                [
                    'offers' => $offers,
                    'paginatedItems' => $paginatedItems,
                    'paginator' => $arrayPaginator,
                    'pagination' => $pagination,
                    'pages' => $pages
                ]
            );
        } else {
            $this->view->assign('offers', $offers);
        }

        $positions = $this->positionRepository->findAll();
        $this->view->assign('positions', $positions);
        $this->view->assign('city', $cityStr);
        $this->view->assign('zip', $zip);
        $this->view->assign('checklistArr', $checklistArr);
    }

    /**
     * action show
     *
     * @param \T3Dev\Cfajob\Domain\Model\Offer $offer
     * @return void
     */
    public function showAction(\T3Dev\Cfajob\Domain\Model\Offer $offer)
    {
        $this->view->assign('offer', $offer);
    }

    /**
     * action new
     *
     * @return void
     */
    public function newAction()
    {
        // Re-captcha to form
        $config = $this->getConfiguration();
        $this->view->assign('useRecaptcha', $config['use_recaptcha']);
        $this->view->assign('clientKey', $config['recaptcha_client_key']);

        $positions = $this->positionRepository->findAll();
        $this->view->assign('positions', $positions);
    }

    /**
     * action new
     *
     * @return void
     */
    public function _newOldAction_not_used()
    {

        // Re-captcha to form
        $config = $this->getConfiguration();
        $this->view->assign('useRecaptcha', $config['use_recaptcha']);
        $this->view->assign('clientKey', $config['recaptcha_client_key']);

        $currentLoggedInUser = $this->frontendUserRepository->findByUid(intval($GLOBALS['TSFE']->fe_user->user['uid']));
        $group = $this->accessService->getFrontendUserGroups();
        $userGroup = $this->settings['groups']['entreprise'];

        if (!is_null($currentLoggedInUser)) {
            if (in_array($userGroup, $group)) {
                $positions = $this->positionRepository->findAll();
                $this->view->assign('positions', $positions);
                $this->view->assign('user', $currentLoggedInUser);

                // We have strange behaviour of Flash messages, because we set conditions to show this messages
                $args = $this->request->getArguments();
                $success = $args['success'];
                if ($success !== null) {
                    if ($success == 1) {
                        $this->flashMessageService('tx_cfajob.message.offer_created', 'okStatus', 'OK');
                    }
                    if ($success == -1) {
                        $this->flashMessageService('tx_cfajob.message.error_has_occurred', 'errorStatus', 'ERROR');
                    }
                }
            } else {
                $this->flashMessageService('tx_cfajob.message.incorrect_login', 'errorStatus', 'ERROR');
            }
        } else {
            $this->flashMessageService('tx_cfajob.message.to_fill_form_please_login', 'errorStatus', 'ERROR');
        }
    }

    /**
     * action create
     *
     * @param Offer $newOffer
     * @return void
     */
    public function createAction(Offer $newOffer)
    {
        $config = $this->getConfiguration();
        $pid = (int)$config['storagePid'];

        // RECAPTCHA validation
        $recaptcha = $_POST['g-recaptcha-response'];
        $captchaObj = GeneralUtility::makeInstance(Recaptcha::class);
        $response = $captchaObj->verifyResponse($recaptcha);

        if ($config['use_recaptcha'] == '1') {
            if (isset($response['success']) && $response['success'] != true) {
                $this->flashMessageService('tx_cfajob.message.error_has_occurred', 'errorStatus', 'ERROR');
                $pageUid = $this->settings['redirectPage'];
                $this->redirect('new', 'Offer', null, ['success' => '-1'], $pageUid);
                exit;
            }
        }

        $usergroup = $this->settings['groups']['entreprise'];
        $usergroupObj = $this->frontendUserGroupRepository->findByUid($usergroup);
        $email = $_POST['tx_cfajob_cfajob']['newOffer']['email'];
        $email = trim($email);
        $user = $this->frontendUserRepository->findOneByEmailAndUsergroup($email, $usergroupObj);

        // Check if city name contains numbers
        $cityTitle = $_POST['city'];
        $cityTitle = trim($cityTitle);
        if ($this->isThereNumber($cityTitle) == true) {
            $this->flashMessageService('tx_cfajob.message.city_contain_numbers', 'errorStatus', 'ERROR');
            $pageUid = $this->settings['redirectPage'];
            $this->redirect('new', 'Offer', null, null, $pageUid);
            exit;
        }

        $post = $_POST['tx_cfajob_cfajob'];
        if (!($user instanceof FrontendUser)) {
            // Create new company
            $user = GeneralUtility::makeInstance(FrontendUser::class);
            $user->setUsername($email);
            $user->setEmail($email);
            $user->setPassword($this->settings['user']['new']['defaultPassword']);
            $user->setCompany($post['company']);
            $user->setTitle($post['company']);
            $user->setZip($post['newOffer']['zip']);
            $user->setWww($post['newOffer']['site']);
            $user->setName($post['newOffer']['contactPerson']);
            $user->setTelephone($post['newOffer']['phone']);
            $user->setPid($this->userOfferPid);
            $this->frontendUserRepository->add($user);
            $this->persistenceManager->persistAll();

            // Convert password to hash
            $hashMethod = UserUtility::getHashMethod();
            UserUtility::convertPassword($user, $hashMethod);

            // Set group
            if ($usergroupObj instanceof FrontendUserGroup) {
                $user->setUsergroup($usergroupObj);
            }
        }

        $cityObj = $this->locationRepository->findOneByName($cityTitle);

        //if (!is_object($cityObj))
        if (!($cityObj instanceof \T3Dev\Cfajob\Domain\Model\Location)) {
            $cityObj = GeneralUtility::makeInstance(Location::class);
            $cityObj->setPid($pid);
            $cityObj->setName($cityTitle);
            $this->locationRepository->add($cityObj);
            $this->persistenceManager->persistAll();
        }

        $newOffer->setPid($pid);
        $newOffer->setCity($cityObj);
        $newOffer->setCompany($user);
        $newOffer->setFrontenduser($user);
        $newOffer->setHidden('1');
        $this->offerRepository->add($newOffer);
        $this->persistenceManager->persistAll();

        // Send email
        $hash = HashUtility::createHashForOffer($newOffer);
        $mailTemplate = 'MailToAdminNewOffer';
        $variables = ['offer' => $newOffer, 'user' => $user, 'hash' => $hash];
        $subject = LocalizationUtility::translate('tx_cfajob.new_offer_subject', 'cfajob');

        /*
        if ($user->getEmail()) {
            $sender = $user->getEmail();
        } else {
            $sender = $this->settings['offer']['mail']['defaultSender'];
        }
        */

        $sender = $this->settings['offer']['mail']['defaultSender'];
        $emails = preg_split('/[;,]/', $this->settings['offer']['mail']['reciever']);
        foreach ($emails as $email) {
            $recipients[] = trim($email);
        }

        // Make instanse for send mail
        $mailUtility = GeneralUtility::makeInstance(MailUtility::class);
        $mailUtility->sendEmail($mailTemplate, $recipients, $sender, $subject, $variables);

        $this->flashMessageService('tx_cfajob.message.offer_created', 'okStatus', 'OK');
        $this->redirect('new', 'Offer', null, null, $this->currentPid);
    }

    /**
     * action edit
     *
     * @param \T3Dev\Cfajob\Domain\Model\Offer $offer
     * @Extbase\IgnoreValidation("offer")
     * @return void
     */
    public function editAction(\T3Dev\Cfajob\Domain\Model\Offer $offer)
    {
        $this->view->assign('offer', $offer);
    }

    /**
     * action edit
     *
     * @param string $hash
     * @Extbase\IgnoreValidation("offer")
     * @return void
     */
    public function enableOfferAction($hash)
    {
        if ($this->request->hasArgument('offer')) {
            $offerUid = $this->request->getArgument('offer');
            $offer = $this->offerRepository->findHiddenByUid($offerUid);
            if (HashUtility::validHash($hash, $offer)) {
                $this->offerRepository->setEnabled($offerUid);
                $this->persistenceManager->persistAll();

                $mailTemplate = 'MailToAdminOfferEnabled';
                $variables = ['offer' => $offer];
                $subject = LocalizationUtility::translate('tx_cfajob.offer_enabled_subject', 'cfajob');
                $sender = $this->settings['offer']['mail']['defaultSender'];
                //$receiver = $this->settings['offer']['mail']['reciever'];
                $emails = preg_split('/[;,]/', $this->settings['offer']['mail']['reciever']);
                foreach ($emails as $email) {
                    $recipients[] = trim($email);
                }

                // Make instanse for send mail
                $mailUtility = GeneralUtility::makeInstance(MailUtility::class);
                $mailUtility->sendEmail($mailTemplate, $recipients, $sender, $subject, $variables);

                $this->flashMessageService('tx_cfajob.message.offer_enabled', 'okStatus', 'OK');
            } else {
                $this->flashMessageService('tx_cfajob.message.incorrect_link', 'errorStatus', 'ERROR');
            }
        }
        $this->redirectToPage($this->settings['offerListPage']);
    }

    /**
     * action update
     *
     * @param \T3Dev\Cfajob\Domain\Model\Offer $offer
     * @return void
     */
    public function updateAction(\T3Dev\Cfajob\Domain\Model\Offer $offer)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->offerRepository->update($offer);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param string $hash
     * @Extbase\IgnoreValidation("offer")
     * @return void
     */
    public function deleteAction($hash)
    {
        if ($this->request->hasArgument('offer')) {
            $offerUid = $this->request->getArgument('offer');
            $offer = $this->offerRepository->findHiddenByUid($offerUid);

            if (HashUtility::validHash($hash, $offer)) {
                $this->offerRepository->remove($offer);
                $offerListPage = $this->settings['offerListPage'];
                $mailTemplate = 'MailToAdminOfferDeleted';
                $variables = ['offer' => $offer, 'offerListPage' => $offerListPage];
                $subject = LocalizationUtility::translate('tx_cfajob.offer_deleted_subject', 'cfajob');
                $sender = $this->settings['offer']['mail']['defaultSender'];
                $emails = preg_split('/[;,]/', $this->settings['offer']['mail']['reciever']);
                foreach ($emails as $email) {
                    $recipients[] = trim($email);
                }

                // Make instanse for send mail
                $mailUtility = GeneralUtility::makeInstance(MailUtility::class);
                $mailUtility->sendEmail($mailTemplate, $recipients, $sender, $subject, $variables);

                $this->flashMessageService('tx_cfajob.message.offer_deleted', 'okStatus', 'OK');
                $this->redirectToPage($this->settings['offerListPage']);
            } else {
                $this->flashMessageService('tx_cfajob.message.incorrect_link', 'errorStatus', 'ERROR');
            }
        } else {
            $this->flashMessageService('tx_cfajob.message.incorrect_link', 'errorStatus', 'ERROR');
            $this->redirectToPage($this->settings['offerListPage']);
        }
    }
}
