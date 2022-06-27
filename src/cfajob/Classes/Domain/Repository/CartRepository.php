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
 * The repository for ClassItems
 */
class CartRepository extends \TYPO3\CMS\Extbase\Persistence\Generic\Session
{
    const SESSIONNAMESPACE = 'tx_cfajob';

    /**
     * @var array
     */
    protected $defaultOrderings = array(
        'sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    );

    /**
     * Returns the object stored in the user´s session
     * @return array $carts
     */
    public function findAll()
    {
        $key = 'carts';
        $carts = array();
        $cartsArray = array();
        $carts_str = $GLOBALS["TSFE"]->fe_user->getKey('ses', self::SESSIONNAMESPACE);

        if (!empty($carts_str)) {
            $cartsArrayUnserialized = unserialize($carts_str);

            if (is_array($cartsArrayUnserialized)) {
                $cartsArray = $cartsArrayUnserialized;
            }
        }

        return $cartsArray;
    }

    /**
     * Returns the object stored in the user´s session
     * @param integer $cart_Index
     * @return array $carts
     */
    public function findCartByIndex($cart_Index)
    {
        $carts = $this->findAll();

        if (isset($carts[$cart_Index])) {
            return $carts[$cart_Index];
        } else {
            return null;
        }
    }

    public function addCart($cart)
    {
        $carts = $this->findAll();
        $carts[] = $cart;
        $this->setCarts($carts);
    }

    /**
     * @param \T3Dev\Cfajob\Domain\Model\Cart $i
     * @param integer $i
     */
    public function setCart(\T3Dev\Cfajob\Domain\Model\Cart $cart, $i)
    {
        $carts = $this->findAll();
        $carts[$i] = $cart;
        $this->setCarts($carts);
    }

    /**
     * @param \T3Dev\Cfajob\Domain\Model\Cart $i
     * @param integer $i
     */
    public function getCart($i)
    {
        $carts = $this->findAll();
        $cart = isset($carts[$i])  ? $carts[$i] : null;
        return $cart;
    }

    /**
     * @param array $carts;
     */
    protected function setCarts($carts)
    {
        $carts = $GLOBALS["TSFE"]->fe_user->setKey('ses', self::SESSIONNAMESPACE, serialize($carts));
    }

    /**
     * Cleans up the session: removes the stored object from the PHP session
     * @return   void
     */
    public function cleanUpSession($key)
    {
        $GLOBALS["TSFE"]->fe_user->setKey('ses', self::SESSIONNAMESPACE, null);
        $GLOBALS['TSFE']->fe_user->storeSessionData();
        return $this;
    }
}
