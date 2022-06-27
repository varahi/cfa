<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function () {
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Pimentconfig',
            'Pimentconfig',
            [
                //Example to request some action
                //\Piment\PimentConfig\Controller\SomeController::class => 'list, show',
            ],
            // non-cacheable actions
            [
            ]
        );

        $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);

        $iconRegistry->registerIcon(
            'piment-plugin-config',
            \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            ['source' => 'EXT:pimentconfig/Resources/Public/Icons/user_plugin_pimentconfig.svg']
        );
    }
);