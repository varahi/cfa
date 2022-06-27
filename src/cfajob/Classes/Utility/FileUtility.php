<?php

declare(strict_types=1);

namespace T3Dev\Cfajob\Utility;

use Exception;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Resource\DuplicationBehavior;
use TYPO3\CMS\Core\Resource\Exception\InsufficientFolderAccessPermissionsException;
use TYPO3\CMS\Core\Resource\Folder;
use TYPO3\CMS\Core\Resource\InaccessibleFolder;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use T3Dev\Cfajob\Domain\Model\FileReference;

/**
 * Class UserUtility
 * @codeCoverageIgnore
 */
class FileUtility
{

    /**
     * Contains the settings of the current extension
     *
     * @var array
     */
    protected $settings;

    /**
     * Initialize methods and form data
     *
     * @return
     */
    public function __construct()
    {
        $this->settings = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_cfajob.']['settings.'];
    }

    public function checkUploadDirectory($confTargetFolder)
    {
        $pathSite = Environment::getPublicPath();
        $targetFolder = $pathSite . $confTargetFolder .'/';

        if (!file_exists($targetFolder)) {
            GeneralUtility::mkdir_deep($targetFolder);
        }

        return $targetFolder;
    }


    public function getConfValidationImage($fieldname = 'image')
    {
        $conf = '';

        if (isset($this->settings['validation']['image'][$fieldname])) {
            $conf = $this->settings['validation']['image'][$fieldname];
            $conf['types'] = GeneralUtility::trimExplode(',', $conf['types']);
            $conf['extensions'] = GeneralUtility::trimExplode(',', $conf['extensions']);
        };
        return $conf;
    }

    /**
     * @param array $tmpName
     * @param integer $storagePid
     * @param string $tablenames
     * @param string $directory
     * @param string $filename
     * @return FileReference|null
     * @throws InsufficientFolderAccessPermissionsException
     * @throws \TYPO3\CMS\Core\Resource\Exception\InsufficientFolderReadPermissionsException
     */
    public function createFileReference($tmpName, $storagePid, $tablenames, $directory, $filename)
    {
        $fileRef = null;
        //$confTargetFolder = $this->settings['upload.']['userdir'];
        //$storage = $this->settings['upload.']['storage'];
        //$storageFolder = $this->getImageStorageFolder($confTargetFolder, $storage);

        $storage = $this->settings['upload.']['storage'];
        $storagePath = $storage . $storagePath;
        $storageFolder = $this->getImageStorageFolder($directory, $storagePath);

        if ($storageFolder) {
            $conflictMode = DuplicationBehavior::RENAME;
            //$fileNameCompleteName = 'user_' . $currentDate . $tmpName;
            $fileObj = $storageFolder->addFile($tmpName, $filename, $conflictMode);
            if ($fileObj) {
                /** @var FileReference $fileRef */
                $fileRef = GeneralUtility::makeInstance(FileReference::class);
                $fileRef->setOriginalResource($fileObj, $storagePid);
                $fileRef->setTablenames($tablenames);
            }
        }

        return $fileRef;
    }

    /**
     * @return Folder|InaccessibleFolder
     * @throws Exception
     * @throws InsufficientFolderAccessPermissionsException
     */
    public function getImageStorageFolder($confTargetFolder, $storage)
    {
        list($storageUid, $folderIdentifier) = GeneralUtility::trimExplode(':', $storage);

        $pathSite = Environment::getPublicPath();
        $userdirPath = $pathSite . $this->settings['upload.']['userdir'] . $confTargetFolder . '/';

        if (!is_dir($userdirPath)) {
            //GeneralUtility::mkdir_deep($targetFolder);
            mkdir($userdirPath, 0755, true);
        }

        $resourceFactory = ResourceFactory::getInstance();
        $storage = $resourceFactory->getStorageObject($storageUid);
        try {
            $folder = $storage->getFolder($folderIdentifier.$confTargetFolder);
        } catch (Exception $exception) {
            return null;
        }

        return $folder;
    }
}
