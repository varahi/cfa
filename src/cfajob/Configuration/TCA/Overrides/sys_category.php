<?php

/**
 * Add extra fields to the sys_category record
 */

$languageFile = 'LLL:EXT:cfajob/Resources/Private/Language/locallang_db.xlf:';

$objectsSysCategoryColumns = [

    'link' => [
        'exclude' => false,
        'label' => $languageFile . 'tx_cfajob_domain_model_category.link',
        'config' => [
            'type' => 'input',
            'renderType' => 'inputLink',
            'size' => 30,
            'eval' => 'trim',
            'softref' => 'typolink',
            'behaviour' => [
                'allowLanguageSynchronization' => true,
            ],
        ]
    ],
    'id' => [
        'exclude' => true,
        'label' => $languageFile . 'tx_cfajob_domain_model_category.id',
        'config' => [
            'type' => 'input',
            'size' => 4,
            'eval' => 'int'
        ]
    ],
    'type' => [
        'exclude' => true,
        'label' => $languageFile . 'tx_cfajob_domain_model_category.type',
        'config' => [
            'type' => 'input',
            'size' => 4,
            'eval' => 'int'
        ]
    ],
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('sys_category', $objectsSysCategoryColumns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('sys_category', '--div--;LLL:EXT:cfajob/Resources/Private/Language/locallang_db.xlf:flexforms_general.images, images', '', 'before:description');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('sys_category', 'link, id, type', '', 'after:description');

$GLOBALS['TCA']['sys_category']['columns']['items']['config']['MM_oppositeUsage']['tx_cfajob_domain_model_training'] = array(0 => 'categories');
