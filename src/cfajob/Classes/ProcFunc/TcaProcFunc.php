<?php

namespace T3Dev\Cfajob\ProcFunc;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use \TYPO3\CMS\Backend\Utility\BackendUtility;

class TcaProcFunc
{

    /**
     * Initializes a TypoScript Frontend necessary for using TypoScript and TypoLink functions
     *
     * @param int $id
     * @param int $typeNum
     */
    protected function initTSFE($id = 1, $typeNum = 0)
    {

        /** @var \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController */
        $tsfe = GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\Controller\\TypoScriptFrontendController', $GLOBALS['TYPO3_CONF_VARS'], $id, $typeNum);
        $tsfe->getConfigArray();
        $tsfe->initTemplate();
    }


    /**
     * @param array $config
     * @return array
     */
    public function companyItems($config)
    {
        //$this->initTSFE();
        //$settings = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_trainingcaces.']['settings.'];
        // ToDo: maybe get setting usergroups from typoscript

        $table = 'fe_users';
        /** @var  \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
        $statement = $queryBuilder
            ->select('*')
            ->from($table)
            ->where($queryBuilder->expr()->eq('usergroup', '2'))
            ->execute();

        while ($rows = $statement->fetchAll()) {
            foreach ($rows as $row) {
                $itemList[] = [$row['username'] .' - ' . $row['company'] .' '. $row['email'], $row['uid']];
            }

            $config['items'] = $itemList;
            return $config;
        }
    }

    /**
     * @param array $config
     * @return array
     */
    public function userItems($config)
    {
        //$this->initTSFE();
        //$settings = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_trainingcaces.']['settings.'];
        // ToDo: maybe get setting usergroups from typoscript

        $table = 'fe_users';
        /** @var  \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
        $statement = $queryBuilder
            ->select('*')
            ->from($table)
            ->where($queryBuilder->expr()->eq('usergroup', '1'))
            ->execute();

        while ($rows = $statement->fetchAll()) {
            foreach ($rows as $row) {
                $itemList[] = [$row['username'] .' - ' . $row['company'] .' '. $row['email'], $row['uid']];
            }

            $config['items'] = $itemList;
            return $config;
        }
    }
}
