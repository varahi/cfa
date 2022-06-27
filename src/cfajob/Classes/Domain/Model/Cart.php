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


/**
 * Cart
 */
class Cart implements \TYPO3\CMS\Core\SingletonInterface
{

    /**
     * uid
     *
     * @var integer
     */
    protected $uid;

    /**
     * Cartnumber
     *
     * @var integer
     */
    protected $number;

    /**
     * items
     *
     * @var array
     */
    protected $items;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        /**
         * Do not modify this method!
         * It will be rewritten on each save in the extension builder
         * You may modify the constructor of this class instead
         */
        $this->items = array();
    }


    /**
     * Returns the number
     *
     * @return integer $number
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Sets the number
     *
     * @param integer $number
     * @return void
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }


    /**
     * Adds a cart item
     *
     * @param array $item
     * @return void
     */
    public function addItem($item)
    {
        $items = $this->getItems();

        if (!is_array($items)) {
            $items = array();
        }

        $notInArray = true;
        foreach ($items as $itemTemp) {
            if (intval($itemTemp->getUid()) == intval($item->getUid())) {
                $notInArray = false;
            }
        }

        if ($notInArray) {
            $items[] = $item;
        }
        $this->setItems($items);

        return $notInArray;
    }


    /**
     * Removes a cart item
     *
     * @param integer $idCart The Item to be removed
     * @return void
     */
    public function removeItem($classItem)
    {
        $items = $this->getItems();
        if (!is_array($items)) {
            $items = array();
        }
        $itemsNew = array();

        $notInArray = true;

        foreach ($items as $key => $itemTemp) {
            if ($itemTemp->getUid() != $classItem) {
                $itemsNew[] = $itemTemp;
            }
        }

        $this->setItems($itemsNew);
    }


    /**
     * Removes all cart item
     *
     * @param integer $idCart The Item to be removed
     * @return void
     */
    public function removeAllItems()
    {
        $items = array();
        $this->setItems($items);
    }

    /**
     * Returns the cart items
     *
     * @return array $items
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Returns the cart items
     *
     * @return object $item
     */
    public function getItem($uid)
    {
        $retVal = false;
        $items = $this->getItems();

        foreach ($items as $item) {
            if ($uid == $item->getUid()) {
                $retVal = $item;
                break;
            }
        }

        return $retVal;
    }

    /**
     * Returns the cart items
     *
     * @return array $items
     */
    public function getCountItems()
    {
        return sizeof($this->getItems());
    }


    /**
     * get price type b2b or b2c
     *
     * @param array $items
     * @return void
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    /**
     * prepare cart to serialise - set item->article to integer
     *
     * @return void
     */
    public function prepareForSerialise()
    {
        $items = $this->getItems();
        foreach ($items as $item) {
            $classItem = $item->getClassItem();

            if (is_object($classItem)) {
                $item->setClassItem($classItem->getUid());
            }
        }
    }
}
