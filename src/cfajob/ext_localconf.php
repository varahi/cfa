<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function () {
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Cfajob',
            'Cfajob',
            [
                \T3Dev\Cfajob\Controller\OfferController::class => 'list, show, new, create, edit, update, delete',
                \T3Dev\Cfajob\Controller\FrontendUserController::class => 'new, lits, create, edit, updateProfile, delete, enableUser, deleteUser, profile',
                \T3Dev\Cfajob\Controller\TrainingController::class => 'list, show',
            ],
            // non-cacheable actions
            [
                \T3Dev\Cfajob\Controller\OfferController::class => 'list, show, new, create, edit, update, delete',
                \T3Dev\Cfajob\Controller\FrontendUserController::class => 'new, lits, create, edit, updateProfile, delete, enableUser, deleteUser, profile',
            ]
        );

        // wizards
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
            'mod {
                wizards.newContentElement.wizardItems.plugins {
                    elements {
                        cfajob {
                            iconIdentifier = cfajob-plugin-cfajob
                            title = LLL:EXT:cfajob/Resources/Private/Language/locallang_db.xlf:tx_cfajob_cfajob.name
                            description = LLL:EXT:cfajob/Resources/Private/Language/locallang_db.xlf:tx_cfajob_cfajob.description
                            tt_content_defValues {
                                CType = list
                                list_type = cfajob_cfajob
                            }
                        }
                    }
                    show = *
                }
           }'
        );
        $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);

        $iconRegistry->registerIcon(
            'cfajob-plugin-cfajob',
            \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            ['source' => 'EXT:cfajob/Resources/Public/Icons/user_plugin_cfajob.svg']
        );
    }
);
