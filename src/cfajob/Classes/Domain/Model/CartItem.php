<?php
namespace T3Dev\Cfajob\Domain\Model;

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

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Cart
 */
class CartItem implements \TYPO3\CMS\Core\SingletonInterface
{

    /**
     * Class item uid
     *
     * @var integer
     */
    protected $uid;

    /**
     * classItem
     *
     * @var string
     */
    protected $item;

    /**
     * Returns the uid
     *
     * @return integer $uid
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Sets the quantity
     *
     * @param integer $uid
     * @return void
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    /**
     * Returns the item
     *
     * @return object $item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Sets the item
     *
     * @param mixed $item
     * @return void
     */
    public function setItem($item)
    {
        $this->item = $item;
    }
}
