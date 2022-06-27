<?php
namespace T3Dev\Cfajob\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;

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
 * The repository for Locations
 */
class LocationRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

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
     * Find by multiple uids using, seperated string. Found on blog.teamgeist-medien.de
     *
     * @param string String containing uids
     * @return \T3Dev\Cfajob\Domain\Model\Location Matching model records
     */
    public function findByUids($uidArray)
    {
        //$uidArray = explode(",", $uids);
        $query = $this->createQuery();
        foreach ($uidArray as $key => $value) {
            $constraints[] =  $query->equals('uid', $value);
        }
        return $query->matching(
            $query->logicalAnd(
                $query->logicalOr(
                    $constraints
                ),
                $query->equals('hidden', 0),
                $query->equals('deleted', 0)
            )
        )->execute();
    }
}
