<?php
namespace T3Dev\Cfajob\Controller;

use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use T3Dev\Cfajob\Service\AccessService;
use T3Dev\Cfajob\Domain\Repository\LocationRepository;
use T3Dev\Cfajob\Domain\Repository\DiplomaRepository;
use T3Dev\Cfajob\Domain\Repository\ExperienceRepository;
use T3Dev\Cfajob\Domain\Repository\PositionRepository;
use T3Dev\Cfajob\Domain\Repository\OfferRepository;
use T3Dev\Cfajob\Domain\Repository\FrontendUserRepository;
use T3Dev\Cfajob\Domain\Repository\FrontendUserGroupRepository;
use T3Dev\Cfajob\Utility\FileUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Core\Resource\ResourceFactory;

/**
 * AbstractController
 */
abstract class AbstractController extends ActionController
{
    const SEPARATOR_TEMP_NAME = '-';

    /**
     * frontendUserRepository
     *
     * @var FrontendUserRepository
     */
    protected $frontendUserRepository = null;

    /**
     * @param FrontendUserRepository $frontendUserRepository
     */
    public function injectFrontendUserRepository(FrontendUserRepository $frontendUserRepository)
    {
        $this->frontendUserRepository = $frontendUserRepository;
    }

    /**
     * frontendUserGroupRepository
     *
     * @var FrontendUserGroupRepository
     */
    protected $frontendUserGroupRepository = null;

    /**
     * @param FrontendUserGroupRepository $frontendUserGroupRepository
     */
    public function injectFrontendUserGroupRepository(FrontendUserGroupRepository $frontendUserGroupRepository)
    {
        $this->frontendUserGroupRepository = $frontendUserGroupRepository;
    }

    /**
     * offerRepository
     *
     * @var OfferRepository
     */
    protected $offerRepository = null;

    /**
     * @param OfferRepository $offerRepository
     */
    public function injectOfferRepository(OfferRepository $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }

    /**
     * positionRepository
     *
     * @var PositionRepository
     */
    protected $positionRepository = null;

    /**
     * @param PositionRepository $positionRepository
     */
    public function injectPositionRepository(PositionRepository $positionRepository)
    {
        $this->positionRepository = $positionRepository;
    }

    /**
     * locationRepository
     *
     * @var LocationRepository
     */
    protected $locationRepository = null;

    /**
     * @param LocationRepository $locationRepository
     */
    public function injectLocationRepository(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    /**
     * diplomaRepository
     *
     * @var DiplomaRepository
     */
    protected $diplomaRepository = null;

    /**
     * @param DiplomaRepository $diplomaRepository
     */
    public function injectdDiplomaRepository(DiplomaRepository $diplomaRepository)
    {
        $this->diplomaRepository = $diplomaRepository;
    }

    /**
     * experienceRepository
     *
     * @var ExperienceRepository
     */
    protected $experienceRepository = null;

    /**
     * @param ExperienceRepository $experienceRepository
     */
    public function injectdExperienceRepository(ExperienceRepository $experienceRepository)
    {
        $this->experienceRepository = $experienceRepository;
    }

    /**
     * @var PersistenceManager
     */
    protected $persistenceManager;

    /**
     * Inject Persistence Manager
     *
     * @param PersistenceManager $persistenceManager
     */
    public function injectPersistenceManager(PersistenceManager $persistenceManager)
    {
        $this->persistenceManager = $persistenceManager;
    }

    /**
     * accessControll
     *
     * @var AccessService
     *
     */
    protected $accessService = null;

    /**
     * @param AccessService $accessService
     */
    public function injectAccessControllService(AccessService $accessService)
    {
        $this->accessService = $accessService;
    }


    /**
     * Build config array (get from $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['cfajob'])
     * if empty then set default values for configuration
     *
     * @return array Configuration
     */
    protected function getConfiguration()
    {
        if (empty($this->configuration)) {
            $configuration = $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['cfajob'];
            if (is_string($configuration)) {
                $configuration = unserialize($configuration);
            }
            if (empty($configuration)) {
                $configuration = array(
                    'storagePid' => '48',
                    'userOfferPid' => '44',
                    'userResumePid' => '87',
                    'use_recaptcha' => '0',
                    'recaptcha_client_key' => '',
                    'recaptcha_secret_key' => ''
                );
            }
            $this->configuration = $configuration;
        }
        return $this->configuration;
    }

    /**
     * @param \string $messageKey
     * @param \string $statusKey
     * @param \string $level
     */
    public function flashMessageService($messageKey, $statusKey, $level)
    {
        switch ($level) {
            case "NOTICE":
                $level = AbstractMessage::NOTICE;
                break;
            case "INFO":
                $level = AbstractMessage::INFO;
                break;
            case "OK":
                $level = AbstractMessage::OK;
                break;
            case "WARNING":
                $level = AbstractMessage::WARNING;
                break;
            case "ERROR":
                $level = AbstractMessage::ERROR;
                break;
        }

        $this->addFlashMessage(
            LocalizationUtility::translate($messageKey, 'cfajob'),
            LocalizationUtility::translate($statusKey, 'cfajob'),
            $level,
            true
        );
    }

    /**
     * redirect to page
     *
     * @return void
     */
    protected function redirectToPage($pageUid)
    {
        $uriBuilder = $this->uriBuilder;
        $uri = $uriBuilder->setTargetPageUid($pageUid)->setTargetPageType(0)->build();
        $this->redirectToURI($uri, $delay=0, $statusCode=200);
    }

    /**
     * Return date object
     *
     * @return object
     */
    protected function getDateObj($data)
    {
        $timestamp = strtotime(str_replace('/', '-', $data));
        $dateFormat = LocalizationUtility::translate('tx_cfajob.dateFormat', 'cfajob');
        $dateStr = date($dateFormat, $timestamp);
        $dateObj = new \DateTime($dateStr);
        return $dateObj;
    }

    /**
     * Set user photo
     *
     * @return void
     */
    public function setUploadFile($newFrontendUser, $property, $directory)
    {
        $newUserFormPage = $this->settings['user']['new']['formPage'];

        $maxUpload = min(ini_get('post_max_size'), ini_get('upload_max_filesize'));
        $maxUpload = str_replace('M', '', $maxUpload);
        $maxUpload = $maxUpload * 1024 * 1024;

        if ($_FILES) {
            for ($i = 0; $i < count($_FILES['tx_cfajob_cfajob']['name'][$property]); $i++) {
                $fileSize = $_FILES['tx_cfajob']['size'][$property][$i];
                if ($fileSize >= $maxUpload) {
                    $this->flashMessageService('tx_cfajob.message.file_too_big', 'errorStatus', 'ERROR');
                    $this->redirect('new', 'FrontendUser', null, [], $newUserFormPage);
                }
            }
            if ($property == 'photo') {
                $this->uploadFile($newFrontendUser, 'photo', 'setPhoto', $directory);
            }
            if ($property == 'cvfile') {
                $this->uploadFile($newFrontendUser, 'cvfile', 'setCvfile', $directory);
            }
        }
    }

    /**
     * Upload file and createFileReference
     *
     * @return void
     */
    public function uploadFile($user, $property, $method, $directory)
    {
        if ($_FILES) {
            /** @var FileUtility $fileUtility */
            $fileUtility = GeneralUtility::makeInstance(FileUtility::class);
            $confTargetFolder = $this->settings['upload.']['userdir'];
            $fileUtility->checkUploadDirectory($confTargetFolder);

            $config = $this->getConfiguration();
            $storagePid = (int)$config['storagePid'];

            $pathSite = Environment::getPublicPath();
            $imageSrcTemp = '';

            // used to avoid dublicates in temp folder
            $separatorTempName = self::SEPARATOR_TEMP_NAME;

            $confTargetFolder = $this->settings['upload.']['temp'];
            $targetFolder = $pathSite . $confTargetFolder;
            foreach ($_FILES['tx_cfajob_cfajob']['name'][$property] as $i => $filename) {
                if ($filename) {
                    $file = [];
                    $file['name'] = $filename;
                    $allowedTypes = explode(',', $this->settings['validation']['image']['extensions']);
                    $typePre = strtolower(strrchr($_FILES['tx_cfajob_cfajob']['name'][$property][$i], '.'));
                    $type = substr($typePre, 1);
                    $allowed = in_array($type, $allowedTypes);
                    if ($allowed === false) {
                        $this->flashMessageService('tx_cfajob.file_extension_denied', 'errorStatus', 'ERROR');
                    } else {
                        $newFileName = end(explode("/", $_FILES['tx_cfajob_cfajob']['tmp_name'][$property][$i])) .
                            $separatorTempName . basename($filename);
                        $tmpFile = $_FILES['tx_cfajob_cfajob']['tmp_name'][$property][$i];
                        if (isset($_FILES['tx_cfajob_cfajob']['tmp_name'])) {
                            if (move_uploaded_file($tmpFile, $targetFolder . '/' . $newFileName)) {
                                $imageSrcTemp = $targetFolder . '/' . $newFileName;
                            }
                        }
                        $fileRef = $fileUtility->createFileReference($imageSrcTemp, $storagePid, 'fe_users', $directory, $filename);
                    }
                }
            }
            $user->$method($fileRef);
        }
        //return $files;
    }

    /**
     * Check if string contains number
     *
     * @return void
     */
    protected function isThereNumber($string)
    {
        $isThereNumber = false;
        for ($i = 0; $i < strlen($string); $i++) {
            if (ctype_digit($string[$i])) {
                $isThereNumber = true;
                break;
            }
        }

        if ($isThereNumber) {
            return true; // String contain numbers
        } else {
            return false; // String doesn't contain numbers
        }
    }
}
