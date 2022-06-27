<?php
declare(strict_types=1);
namespace T3Dev\Cfajob\ViewHelpers\Be;

use T3Dev\Cfajob\Utility\ConfigurationUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Class IsConfirmationModuleActivatedViewHelper
 */
class IsConfirmationModuleActivatedViewHelper extends AbstractViewHelper
{

    /**
     * @return bool
     */
    public function render(): bool
    {
        return ConfigurationUtility::isConfirmationModuleActive();
    }
}
