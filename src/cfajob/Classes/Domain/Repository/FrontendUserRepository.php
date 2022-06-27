<?php
namespace T3Dev\Cfajob\Domain\Repository;

#use TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository;
use T3Dev\Cfajob\Utility\BackendUserUtility;
use T3Dev\Cfajob\Utility\BackendUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use T3Dev\Cfajob\Domain\Model\FrontendUserGroup;
use T3Dev\Cfajob\Domain\Model\Location;

/***
 *
 * This file is part of the "CFA Job" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020 Dmitry Vasilev <dmitry@t3dev.ru>, T3Dev
 *
 ***/
/**
 * The repository for FrontendUsers
 */
class FrontendUserRepository extends \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository
{
    private $table = 'fe_users';

    /**
     * Initializes the repository.
     *
     * @return void
     * @see \TYPO3\CMS\Extbase\Persistence\Repository::initializeObject()
     */
    public function initializeObject()
    {
        // Load the querySettings
        /** @var $querySettings Typo3QuerySettings */
        $querySettings = $this->objectManager->get(Typo3QuerySettings::class);
        // Ignore hidden and deleted records
        $querySettings
            ->setIncludeDeleted(false)
            ->setIgnoreEnableFields(true)
            ->setRespectStoragePage(false);

        // Set your settings as default for the entire Repository
        $this->setDefaultQuerySettings($querySettings);
    }


    public function setDisable($uid)
    {

        /** @var  \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($this->table);
        //$queryBuilder->setValue('disable', '1')->execute();
        $queryBuilder->update('fe_users')
            ->where(
                $queryBuilder->expr()->eq(
                    'uid',
                    $queryBuilder->createNamedParameter($uid)
                )
            )
            ->set('disable', '1')
            ->execute();
    }


    /**
     *
     * @param FrontendUserGroup $usergroup
     *
     */
    public function findByUsergroup(
        FrontendUserGroup $usergroup
    ) {
        $query = $this->createQuery();
        $query->getQuerySettings()
            ->setIgnoreEnableFields(false);

        $constraints = [];
        $constraints[] = $query->logicalOr(
            $query->logicalAnd(
                $query->equals('usergroup', $usergroup)
            )
        );
        $query->matching($query->logicalAnd($constraints));

        return $query
            ->setOrderings(array('crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING))
            ->execute();
    }

    /**
     * Find by multiple uids using, seperated string. Found on blog.teamgeist-medien.de
     *
     * @param string String containing uids
     * @param FrontendUserGroup $usergroup
     * @return \T3Dev\Cfajob\Domain\Model\Offer Matching model records
     */
    public function findByPositionsAndGroup($uidArray, FrontendUserGroup $usergroup)
    {
        //$uidArray = explode(",", $uids);
        $query = $this->createQuery();
        foreach ($uidArray as $key => $value) {
            $constraints[] =  $query->equals('position', $value);
        }
        return $query->matching(
            $query->logicalAnd(
                $query->equals('usergroup', $usergroup),
                $query->logicalOr(
                    $constraints
                ),
                $query->equals('disable', 0),
                $query->equals('deleted', 0)
            )
        )->execute();
    }

    /**
     *
     * @param Location $city
     * @param FrontendUserGroup $usergroup
     * @var array
     *
     */
    public function findByTypeAndCity($filterId, Location $city, FrontendUserGroup $usergroup)
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                $query->equals('position', $filterId),
                $query->equals('location', $city),
                $query->equals('usergroup', $usergroup)
            )
        );

        return $query->execute();
    }

    /**
     *
     * @var array
     * @param FrontendUserGroup $usergroup
     *
     */
    public function findByTypeAndZip($filterId, $zip, FrontendUserGroup $usergroup)
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                $query->equals('position', $filterId),
                $query->equals('usergroup', $usergroup),
                $query->like('zip', '%'.$zip.'%')
            )
        );

        return $query->execute();
    }

    /**
     *
     * @param Location $city
     * @param FrontendUserGroup $usergroup
     *
     * @var array
     */
    public function findByTypeAndCityAndZip($filterId, Location $city, $zip, FrontendUserGroup $usergroup)
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                $query->equals('position', $filterId),
                $query->equals('location', $city),
                $query->equals('usergroup', $usergroup),
                $query->like('zip', '%'.$zip.'%')
            )
        );

        return $query->execute();
    }

    public function setEnabled($uid)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('fe_users');
        $queryBuilder
            ->update('fe_users')
            ->set('deleted', '0')
            ->set('disable', '0')
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid))
            )
            ->execute();
    }

    public function removeFileReference($uid)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('fe_users');
        $queryBuilder
            ->update('sys_file_reference')
            ->set('deleted', '1')
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid))
            )
            ->execute();
    }

    public function findHiddenByUid($uid)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setIgnoreEnableFields(true);
        $query->matching($query->equals('uid', $uid));
        return $query->execute()->getFirst();
    }

    /**
     *
     * @param string $email
     * @param FrontendUserGroup $usergroup
     *
     * @var array
     */
    public function findOneByEmailAndUsergroup($email, FrontendUserGroup $usergroup)
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                $query->equals('email', $email),
                $query->equals('usergroup', $usergroup)
            )
        );

        return $query->execute()->getFirst();
    }

    /**
     * @param QueryInterface $query
     * @return void
     */
    protected function ignoreEnableFieldsAndStoragePage(QueryInterface $query)
    {
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->getQuerySettings()->setIgnoreEnableFields(true);
        $query->getQuerySettings()->setEnableFieldsToBeIgnored(['disabled']);
    }

    /**
     * Find all users from current page or from any subpage
     * If no page id given or if on rootpage (pid 0):
     *      - Don't show any users for editors
     *      - Show all users for admins
     *
     * @param array $and
     * @param QueryInterface $query
     * @return array
     */
    protected function filterByPage(array $and, QueryInterface $query): array
    {
        if (BackendUtility::getPageIdentifier() > 0) {
            $and[] = $query->in('pid', $this->getTreeList(BackendUtility::getPageIdentifier()));
        } else {
            if (!BackendUserUtility::isAdminAuthentication()) {
                $and[] = $query->equals('uid', 0);
            }
        }

        return $and;
    }

    /**
     * @param array $filter
     * @param QueryInterface $query
     * @param array $and
     * @return array
     */
    protected function filterBySearchword(array $filter, QueryInterface $query, array $and): array
    {
        if (!empty($filter['searchword'])) {
            $searchwords = GeneralUtility::trimExplode(' ', $filter['searchword'], true);
            foreach ($searchwords as $searchword) {
                $or = [];
                $or[] = $query->like('address', '%' . $searchword . '%');
                $or[] = $query->like('city', '%' . $searchword . '%');
                $or[] = $query->like('company', '%' . $searchword . '%');
                $or[] = $query->like('country', '%' . $searchword . '%');
                $or[] = $query->like('email', '%' . $searchword . '%');
                $or[] = $query->like('fax', '%' . $searchword . '%');
                $or[] = $query->like('first_name', '%' . $searchword . '%');
                $or[] = $query->like('image', '%' . $searchword . '%');
                $or[] = $query->like('last_name', '%' . $searchword . '%');
                $or[] = $query->like('middle_name', '%' . $searchword . '%');
                $or[] = $query->like('name', '%' . $searchword . '%');
                $or[] = $query->like('telephone', '%' . $searchword . '%');
                $or[] = $query->like('title', '%' . $searchword . '%');
                $or[] = $query->like('usergroup.title', '%' . $searchword . '%');
                $or[] = $query->like('username', '%' . $searchword . '%');
                $or[] = $query->like('www', '%' . $searchword . '%');
                $or[] = $query->like('zip', '%' . $searchword . '%');
                $and[] = $query->logicalOr($or);
            }
        }

        return $and;
    }

    /**
     * Get all children pids of a start pid
     *
     * @param int $pageIdentifier
     * @return array
     */
    protected function getTreeList($pageIdentifier)
    {
        $queryGenerator = $this->objectManager->get('TYPO3\\CMS\\Core\\Database\\QueryGenerator');
        $treeList = $queryGenerator->getTreeList($pageIdentifier, 99, 0, '1');

        return GeneralUtility::trimExplode(',', $treeList, true);
    }

    /**
     * Find All for Backend Actions
     *
     * @param array $filter Filter Array
     * @return QueryResultInterface|array
     */
    public function findAllInBackend(array $filter)
    {
        $query = $this->createQuery();
        $this->ignoreEnableFieldsAndStoragePage($query);
        $and = [$query->greaterThan('uid', 0)];
        $and = $this->filterByPage($and, $query);
        $and = $this->filterBySearchword($filter, $query, $and);
        $query->matching($query->logicalAnd($and));
        $query->setOrderings(['username' => QueryInterface::ORDER_ASCENDING]);
        $records = $query->execute();

        return $records;
    }
}
