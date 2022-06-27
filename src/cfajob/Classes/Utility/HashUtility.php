<?php
declare(strict_types=1);

namespace T3Dev\Cfajob\Utility;

use T3Dev\Cfajob\Domain\Model\FrontendUser as User;
use T3Dev\Cfajob\Domain\Model\Offer;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class HashUtility
 */
class HashUtility extends AbstractUtility
{

    /**
     * Check if given hash is correct
     *
     * @param string $hash
     * @param Offer $offer
     * @return bool
     */
    public static function validHash($hash, Offer $offer)
    {
        return self::createHashForOffer($offer) === $hash;
    }

    /**
     * Create hash for a user
     *
     * @param Offer $offer
     * @return string
     */
    public static function createHashForOffer(Offer $offer)
    {
        return self::hashString($offer->getName());
    }


    /**
     * Create Hash from String and TYPO3 Encryption Key (if available)
     *
     * @param string $string Any String to hash
     * @param int $length Hash Length
     * @return string $hash Hashed String
     */
    protected static function hashString($string, $length = 16)
    {
        return GeneralUtility::shortMD5($string . self::getEncryptionKey(), $length);
    }

    /**
     * Check if given hash is correct
     *
     * @param string $hash
     * @param \T3Dev\Cfajob\Domain\Model\User $user
     * @return bool
     */
    public static function validUserHash($hash, User $user)
    {
        return self::createHashForUser($user) === $hash;
    }

    /**
     * Create hash for a user
     *
     * @param User $user
     * @return string
     */
    public static function createHashForUser(User $user)
    {
        return self::hashString($user->getUsername());
    }
}
