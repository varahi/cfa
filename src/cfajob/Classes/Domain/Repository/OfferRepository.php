<?php
namespace T3Dev\Cfajob\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use T3Dev\Cfajob\Domain\Model\Location;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

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
 * The repository for Offers
 */
class OfferRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * locationRepository
     *
     * @var LocationRepository
     */
    protected $locationRepository = null;

    /**
     * @param LocationRepository $locationRepository
     */
    public function injectLocationRepository(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    /**
     * Initializes the repository.
     *
     * @return void
     * @see Repository::initializeObject()
     */
    public function initializeObject()
    {
        // Load the querySettings
        /** @var $querySettings Typo3QuerySettings */
        $querySettings = $this->objectManager->get(Typo3QuerySettings::class);
        // Ignore hidden and deleted records
        $querySettings
            ->setIncludeDeleted(false)
            ->setIgnoreEnableFields(false)
            ->setRespectStoragePage(false);

        // Set your settings as default for the entire Repository
        $this->setDefaultQuerySettings($querySettings);
    }

    /**
     * @var array
     */
    protected $defaultOrderings = ['crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING];


    public function setEnabled($uid)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_cfajob_domain_model_offer');
        $queryBuilder
            ->update('tx_cfajob_domain_model_offer')
            ->set('deleted', '0')
            ->set('hidden', '0')
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
     * Find by multiple params
     *
     * @param string $uid
     * @param string $cityStr
     * @param string $filterArr
     *
     * @return \T3Dev\Cfajob\Domain\Model\Offer Matching model records
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findByParams($zip, $cityStr, $filterArr)
    {
        $query = $this->createQuery();

        if ($zip) {
            if (strlen((string)$zip) <= 2) {
                $constraints[] = $query->logicalOr(
                    $query->like('zip', $zip.'%')
                );
            } else {
                $constraints[] = $query->logicalOr(
                    $query->like('zip', '%'.$zip.'%')
                );
            }
        }

        if($cityStr) {
            $cityObj = $this->locationRepository->findOneByName($cityStr);
            if ($cityObj instanceof Location) {
                $constraints[] = $query->logicalOr(
                    $query->equals('city', $cityObj),
                );
            } else {
                $constraints[] = $query->logicalOr(
                    $query->like('city.name', '%'.$cityStr.'%')
                );
            }
        }

        if ($filterArr) {
            $constraints[] = $query->logicalOr(
                $query->in('type.uid', [$filterArr])
            );
        }

        $query->setOrderings([
            'crdate' => QueryInterface::ORDER_DESCENDING
        ])->setLimit((int)9999)->execute();

        $query->matching($query->logicalAnd($constraints));

        return $query->execute();
    }
}
