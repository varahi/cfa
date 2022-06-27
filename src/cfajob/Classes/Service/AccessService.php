<?php
namespace T3Dev\Cfajob\Service;

use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Crypto\PasswordHashing\PasswordHashFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use T3Dev\Cfajob\Domain\Repository\FrontendUserRepository;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use T3Dev\Cfajob\Utility\ObjectUtility;
use TYPO3\CMS\Core\SingletonInterface;

class AccessService implements SingletonInterface
{


    /**
     * Do we have a logged in feuser
     * @return boolean
     */
    public function hasLoggedInFrontendUser()
    {
        $context = GeneralUtility::makeInstance(Context::class);
        $userIsLoggedIn = $context->getPropertyFromAspect('frontend.user', 'isLoggedIn');

        return $userIsLoggedIn;
    }

    /**
     * @return array
     */
    public function getFrontendUserGroups()
    {
        if ($this->hasLoggedInFrontendUser()) {
            return $GLOBALS['TSFE']->fe_user->groupData['uid'];
        }
        return array();
    }

    /**
     * Get the uid of the current feuser
     * @return mixed
     */
    public function getFrontendUserUid()
    {
        if ($this->hasLoggedInFrontendUser() && !empty($GLOBALS['TSFE']->fe_user->user['uid'])) {
            return intval($GLOBALS['TSFE']->fe_user->user['uid']);
        }
        return null;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $user
     * @return boolean
     */
    public function isAccessAllowed(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $user)
    {
        return $this->getFrontendUserUid() === $user->getUid() ? true : false;
    }
}
