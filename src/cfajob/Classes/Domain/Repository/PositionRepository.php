<?php
namespace T3Dev\Cfajob\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;
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
 * The repository for Positions
 */
class PositionRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
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
            ->setIncludeDeleted(true)
            ->setIgnoreEnableFields(true)
            ->setRespectStoragePage(false);

        // Set your settings as default for the entire Repository
        $this->setDefaultQuerySettings($querySettings);
    }
}
