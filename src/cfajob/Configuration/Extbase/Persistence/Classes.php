<?php
declare(strict_types = 1);

return [

    \T3Dev\Cfajob\Domain\Model\FrontendUser::class => [
        'tableName' => 'fe_users',
    ],
    \T3Dev\Cfajob\Domain\Model\FrontendUserGroup::class => [
        'tableName' => 'fe_groups',
        'properties' => [
            'feloginRedirectPid' => [
                'fieldName' => 'felogin_redirectPid'
            ],
        ],
    ],
    \T3Dev\Cfajob\Domain\Model\FileReference::class => [
        'tableName' => 'sys_file_reference',
    ],
    \T3Dev\Cfajob\Domain\Model\Category::class => [
        'tableName' => 'sys_category',
        'properties' => [
            'parentcategory' => [
                'fieldName' => 'parent'
            ],
        ],
    ],

];
