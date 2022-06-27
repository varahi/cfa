<?php

declare(strict_types=1);

namespace T3Dev\Cfajob\Controller;

use T3Dev\Cfajob\Domain\Model\FrontendUser as User;
#use T3Dev\Cfajob\Event\AdminConfirmationUserEvent;
#use T3Dev\Cfajob\Event\RefuseUserEvent;
use T3Dev\Cfajob\Utility\ConfigurationUtility;
use T3Dev\Cfajob\Utility\HashUtility;
#use T3Dev\Cfajob\Utility\LocalizationUtility;
use T3Dev\Cfajob\Utility\UserUtility;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class UserBackendController
 */
class UserBackendController extends AbstractController
{
    protected $configPID;

    /**
     * @param array $filter
     * @return void
     */
    public function listAction(array $filter = [])
    {
        $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
        $loginAsEnabled = $GLOBALS['BE_USER']->user['admin'] === 1 || (int)$GLOBALS['BE_USER']->getTSConfig(
            )['tx_cfajob.']['UserBackend.']['enableLoginAs'] === 1;
        $this->view->assignMultiple(
            [
                'users' => $this->frontendUserRepository->findAllInBackend($filter),
                'moduleUri' => $uriBuilder->buildUriFromRoute('tce_db'),
                'action' => 'list',
                'loginAsEnabled' => $loginAsEnabled
            ]
        );
    }
}
