<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:cfajob/Resources/Private/Language/locallang_db.xlf:tx_cfajob_domain_model_offer',
        'label' => 'uid',
        'label_alt' => 'name,city',
        //'label_alt' => 'name,email,crdate',
        'label_alt_force' => 1,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'name,description,email,company,contact_person,site,phone,type,city,zip',
        'iconfile' => 'EXT:cfajob/Resources/Public/Icons/tx_cfajob_domain_model_offer.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, description, email, company, frontenduser,
        contact_person, site, phone, type, city, zip, crdate',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, crdate, description, email, company, frontenduser, contact_person, site, phone, type, city, zip, 
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ]
                ],
                'default' => 0,
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_cfajob_domain_model_offer',
                'foreign_table_where' => 'AND {#tx_cfajob_domain_model_offer}.{#pid}=###CURRENT_PID### AND {#tx_cfajob_domain_model_offer}.{#sys_language_uid} IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true
                    ]
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],

        'name' => [
            'exclude' => true,
            'label' => 'LLL:EXT:cfajob/Resources/Private/Language/locallang_db.xlf:tx_cfajob_domain_model_offer.name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ],
        ],
        'description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:cfajob/Resources/Private/Language/locallang_db.xlf:tx_cfajob_domain_model_offer.description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ],
        'email' => [
            'exclude' => true,
            'label' => 'LLL:EXT:cfajob/Resources/Private/Language/locallang_db.xlf:tx_cfajob_domain_model_offer.email',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'contact_person' => [
            'exclude' => true,
            'label' => 'LLL:EXT:cfajob/Resources/Private/Language/locallang_db.xlf:tx_cfajob_domain_model_offer.contact_person',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'site' => [
            'exclude' => true,
            'label' => 'LLL:EXT:cfajob/Resources/Private/Language/locallang_db.xlf:tx_cfajob_domain_model_offer.site',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'phone' => [
            'exclude' => true,
            'label' => 'LLL:EXT:cfajob/Resources/Private/Language/locallang_db.xlf:tx_cfajob_domain_model_offer.phone',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'type' => [
            'exclude' => true,
            'label' => 'LLL:EXT:cfajob/Resources/Private/Language/locallang_db.xlf:tx_cfajob_domain_model_offer.type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_cfajob_domain_model_position',
                'default' => 0,
                'minitems' => 0,
                'maxitems' => 1,
            ],

        ],
        'city' => [
            'exclude' => true,
            'label' => 'LLL:EXT:cfajob/Resources/Private/Language/locallang_db.xlf:tx_cfajob_domain_model_offer.city',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_cfajob_domain_model_location',
                'default' => 0,
                'minitems' => 0,
                'maxitems' => 1,
            ],

        ],
        'zip' => [
            'exclude' => true,
            'label' => 'LLL:EXT:cfajob/Resources/Private/Language/locallang_db.xlf:tx_cfajob_domain_model_offer.zip',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],

        ],
        'company' => [
            'exclude' => true,
            'label' => 'LLL:EXT:cfajob/Resources/Private/Language/locallang_db.xlf:tx_cfajob_domain_model_offer.company',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                //'foreign_table' => 'fe_users',
                'itemsProcFunc' => 'T3Dev\\Cfajob\\ProcFunc\\TcaProcFunc->companyItems',
                'default' => 0,
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'frontenduser' => [
            'exclude' => true,
            'label' => 'LLL:EXT:cfajob/Resources/Private/Language/locallang_db.xlf:tx_cfajob_domain_model_offer.frontenduser',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'fe_users',
                'default' => 0,
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'crdate' => [
            'exclude' => true,
            'label' => 'LLL:EXT:cfajob/Resources/Private/Language/locallang_db.xlf:tx_cfajob_domain_model_offer.crdate',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 4,
                'eval' => 'datetime',
                'default' => time()
            ]
        ],
        /*
        'crdate' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        */

        /*
        'frontenduser' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        */
    ],
];
