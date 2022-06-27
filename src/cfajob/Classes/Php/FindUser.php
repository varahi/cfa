<?php

namespace T3Dev\Cfajob\Php;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class FindUser
{
    public function numRows($email)
    {
        $table = 'fe_users';

        /** @var  \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
        $statement = $queryBuilder
            ->select('uid')
            ->from($table)
            ->where($queryBuilder->expr()->eq('usergroup', '1'))
            ->andWhere($queryBuilder->expr()->eq('email', $queryBuilder->createNamedParameter($email)))
            ->execute();

        $rows = $statement->fetchAll();
        return $rows;
    }
}
