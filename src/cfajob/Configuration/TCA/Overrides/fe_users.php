<?php

defined('TYPO3_MODE') || die();

call_user_func(function () {
    $languageFile = 'LLL:EXT:cfajob/Resources/Private/Language/locallang_db.xlf:';

    $temporaryColumns = [
        'gender' => [
            'label' => $languageFile . 'fe_users.gender',
            'config' => [
                'type' => 'radio',
                'items' => [
                    [$languageFile . 'fe_users.gender.I.1', '1'],
                    [$languageFile . 'fe_users.gender.I.2', '2']
                ],
            ]
        ],
        'title_c_v' => [
            'exclude' => true,
            'label' => $languageFile . 'tx_cfajob_domain_model_frontenduser.title_c_v',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'contact_person' => [
            'exclude' => true,
            'label' => $languageFile . 'tx_cfajob_domain_model_frontenduser.contact_person',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'diploma' => [
            'exclude' => true,
            'label' => $languageFile . 'tx_cfajob_domain_model_frontenduser.diploma',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_cfajob_domain_model_diploma',
                'foreign_field' => 'user',
                'maxitems' => 9999,
                'appearance' => [
                    'collapseAll' => 1,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],

        ],
        'experience' => [
            'exclude' => true,
            'label' => $languageFile . 'tx_cfajob_domain_model_frontenduser.experience',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_cfajob_domain_model_experience',
                'foreign_field' => 'user',
                'maxitems' => 9999,
                'appearance' => [
                    'collapseAll' => 1,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],

        ],
        'location' => [
            'exclude' => true,
            'label' => $languageFile . 'tx_cfajob_domain_model_frontenduser.location',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_cfajob_domain_model_location',
                'default' => 0,
                'minitems' => 0,
                'maxitems' => 1,
            ],

        ],
        'position' => [
            'exclude' => true,
            'label' => $languageFile . 'tx_cfajob_domain_model_frontenduser.position',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_cfajob_domain_model_position',
                'default' => 0,
                'minitems' => 0,
                'maxitems' => 1,
            ],

        ],
        'offer' => [
            'exclude' => true,
            'label' => $languageFile . 'tx_cfajob_domain_model_frontenduser.offer',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_cfajob_domain_model_offer',
                'foreign_field' => 'frontenduser',
                'maxitems' => 9999,
                'appearance' => [
                    'collapseAll' => 1,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],

        ],
        'about' => [
            'exclude' => true,
            'label' => $languageFile . 'tx_cfajob_domain_model_frontenduser.about',
            'config' => [
                'type' => 'text',
                'rows' => 5,
                'cols' => 48,
                'default' => '',
            ],
        ],
        'photo' => [
            'exclude' => true,
            'label' => 'LLL:EXT:cfajob/Resources/Private/Language/locallang_db.xlf:tx_cfajob_domain_model_frontenduser.photo',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'photo',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
                    ],
                    'foreign_types' => [
                        '0' => [
                            'showitem' => '
                        --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
                            'showitem' => '
                        --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                            'showitem' => '
                        --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
                            'showitem' => '
                        --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                            'showitem' => '
                        --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                            'showitem' => '
                        --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette'
                        ]
                    ],
                    'foreign_match_fields' => [
                        'fieldname' => 'photo',
                        'tablenames' => 'fe_users',
                        'table_local' => 'sys_file',
                    ],
                    'maxitems' => 1
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),

        ],
        'cvfile' => [
            'exclude' => true,
            'label' => 'LLL:EXT:cfajob/Resources/Private/Language/locallang_db.xlf:tx_cfajob_domain_model_frontenduser.cvfile',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'cvfile',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
                    ],
                    'foreign_types' => [
                        '0' => [
                            'showitem' => '
                        --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
                            'showitem' => '
                        --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                            'showitem' => '
                        --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
                            'showitem' => '
                        --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                            'showitem' => '
                        --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                            'showitem' => '
                        --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette'
                        ]
                    ],
                    'foreign_match_fields' => [
                        'fieldname' => 'cvfile',
                        'tablenames' => 'fe_users',
                        'table_local' => 'sys_file',
                    ],
                    'maxitems' => 1
                ],
                //$GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),

        ],
        'path_segment' => [
            'label' => 'LLL:EXT:cfajob/Resources/Private/Language/locallang_db.xlf:tx_cfajob_domain_model_training.path_segment',
            'config' => [
                'type' => 'slug',
                'size' => 50,
                'generatorOptions' => [
                    'fields' => ['first_name', 'last_name'],
                    'fieldSeparator' => '-',
                    'prependSlash' => true,
                    'prefixParentPageSlug' => true,
                    'replacements' => [
                        '/' => '',
                    ],
                ],
                'fallbackCharacter' => '-',
                'eval' => 'uniqueInSite',
                'default' => ''
            ]
        ],
        'crdate' => [
            'exclude' => 1,
            'label' => $languageFile . 'tx_cfajob_domain_model_frontenduser.crdate',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 30,
                'eval' => 'datetime',
                'readOnly' => true,
                'default' => time()
            ]
        ],

    ];

    $fields = 'crdate, photo, title_c_v, cvfile, diploma, experience, location, position, offer, about';

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users', $temporaryColumns);
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'fe_users',
        '--div--;LLL:EXT:cfajob/Resources/Private/Language/locallang_db.xlf:fe_users.div.additional, ' . $fields
    );
});
