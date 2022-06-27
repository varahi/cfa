<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function () {
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'T3Dev.Cfajob',
            'Cfajob',
            'CFA Job'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('cfajob', 'Configuration/TypoScript', 'CFA Job');

        // Add FlexForm
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['cfajob_cfajob'] = 'recursive,select_key,pages';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['cfajob_cfajob'] = 'pi_flexform';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
            'cfajob_cfajob',
            'FILE:EXT:cfajob/Configuration/FlexForms/flexform_cfajob.xml'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_cfajob_domain_model_diploma', 'EXT:cfajob/Resources/Private/Language/locallang_csh_tx_cfajob_domain_model_diploma.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_cfajob_domain_model_diploma');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_cfajob_domain_model_experience', 'EXT:cfajob/Resources/Private/Language/locallang_csh_tx_cfajob_domain_model_experience.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_cfajob_domain_model_experience');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_cfajob_domain_model_location', 'EXT:cfajob/Resources/Private/Language/locallang_csh_tx_cfajob_domain_model_location.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_cfajob_domain_model_location');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_cfajob_domain_model_position', 'EXT:cfajob/Resources/Private/Language/locallang_csh_tx_cfajob_domain_model_position.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_cfajob_domain_model_position');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_cfajob_domain_model_offer', 'EXT:cfajob/Resources/Private/Language/locallang_csh_tx_cfajob_domain_model_offer.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_cfajob_domain_model_offer');

        // Custom
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('fe_users', 'sorting;;;;1-1-1');

        $GLOBALS['TCA']['fe_users']['ctrl']['sortby'] = 'uid';
        unset($GLOBALS['TCA']['fe_users']['ctrl']['default_sortby']);

        /**
         * Include Backend Module
         */
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
            'T3Dev.Cfajob',
            'web', // Make module a submodule of 'web'
            'm1', // Submodule key
            '', // Position
            [
                //\T3Dev\Test\Controller\UserController::class => 'list, show, new, create, edit, update, delete',
                'UserBackend' => 'list,confirmation,userLogout,confirmUser,refuseUser,listOpenUserConfirmations,resendUserConfirmationRequest'
            ],
            [
                'access' => 'user,group',
                'icon'   => 'EXT:cfajob/Resources/Public/Icons/user_mod.svg',
                'labels' => 'LLL:EXT:cfajob/Resources/Private/Language/locallang_mod.xlf',
            ]
        );
    }
);
