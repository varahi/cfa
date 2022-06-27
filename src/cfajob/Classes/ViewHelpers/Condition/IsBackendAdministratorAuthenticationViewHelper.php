<?php
declare(strict_types=1);
namespace T3Dev\Cfajob\ViewHelpers\Condition;

use T3Dev\Cfajob\Utility\BackendUserUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Class IsBackendAdministratorAuthenticationViewHelper
 */
class IsBackendAdministratorAuthenticationViewHelper extends AbstractViewHelper
{

    /**
     * Check if a backenduser-administrator is logged in
     *
     * @return bool
     */
    public function render()
    {
        return BackendUserUtility::isAdminAuthentication();
    }
}
