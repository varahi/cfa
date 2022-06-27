<?php
declare(strict_types=1);
namespace T3Dev\Cfajob\Utility;

use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;

/**
 * Class BackendUserUtility
 */
class BackendUserUtility extends AbstractUtility
{

    /**
     * @return bool
     */
    public static function isAdminAuthentication()
    {
        $userAuthentication = self::getBackendUserAuthentication();

        return $userAuthentication->user['admin'] === 1 || (int)$userAuthentication->getTSConfig()['tx_cfajob.']['UserBackend.']['enableLoginAs'] === 1;
    }

    /**
     * @return BackendUserAuthentication
     */
    public static function getBackendUserAuthentication()
    {
        return parent::getBackendUserAuthentication();
    }
}
