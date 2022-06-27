<?php

declare(strict_types=1);

namespace T3Dev\Cfajob\Utility;

use T3Dev\Cfajob\Domain\Model\FrontendUser as User;
use TYPO3\CMS\Core\Crypto\PasswordHashing\Argon2iPasswordHash;
use TYPO3\CMS\Core\Crypto\PasswordHashing\BcryptPasswordHash;
use TYPO3\CMS\Core\Crypto\PasswordHashing\BlowfishPasswordHash;
use TYPO3\CMS\Core\Crypto\PasswordHashing\Md5PasswordHash;
use TYPO3\CMS\Core\Crypto\PasswordHashing\PasswordHashFactory;
use TYPO3\CMS\Core\Crypto\PasswordHashing\Pbkdf2PasswordHash;
use TYPO3\CMS\Core\Crypto\PasswordHashing\PhpassPasswordHash;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class UserUtility
 * @codeCoverageIgnore
 */
class UserUtility extends AbstractUtility
{


    /**
     * Hash a password from $user->getPassword()
     *
     * @param User $user
     * @param string $method "Argon2i", "Bcrypt", "Pbkdf2", "Phpass", "Blowfish", "md5" or "none" ("sha1" for TYPO3 V8)
     * @return void
     * @throws \TYPO3\CMS\Core\Crypto\PasswordHashing\InvalidPasswordHashException
     */
    public static function convertPassword(User &$user, $method)
    {
        $hashInstance = false;
        $saltedHashPassword = $user->getPassword();
        /** @var PasswordHashFactory $passwordHashFactory */
        $passwordHashFactory = GeneralUtility::makeInstance(PasswordHashFactory::class);
        switch ($method) {
            case 'Argon2i':
                $hashInstance = GeneralUtility::makeInstance(Argon2iPasswordHash::class);
                break;

            case 'Bcrypt':
                $hashInstance = GeneralUtility::makeInstance(BcryptPasswordHash::class);
                break;

            case 'Pbkdf2':
                $hashInstance = GeneralUtility::makeInstance(Pbkdf2PasswordHash::class);
                break;

            case 'Phpass':
                $hashInstance = GeneralUtility::makeInstance(PhpassPasswordHash::class);
                break;

            case 'Blowfish':
                $hashInstance = GeneralUtility::makeInstance(BlowfishPasswordHash::class);
                break;

            case 'md5':
                $hashInstance = GeneralUtility::makeInstance(Md5PasswordHash::class);
                break;
            case 'none':
                break;

            default:
                $hashInstance = $passwordHashFactory->getDefaultHashInstance(TYPO3_MODE);
        }

        if ($hashInstance === false) {
            $user->setPassword($saltedHashPassword);
        } else {
            $user->setPassword($hashInstance->getHashedPassword($saltedHashPassword));
        }
    }

    /**
     * Hash a password from $user->getPassword()
     *
     * @param string $method "Argon2i", "Bcrypt", "Pbkdf2", "Phpass", "Blowfish", "md5" or "none" ("sha1" for TYPO3 V8)
     *
     * @return void
     */
    public static function getHashMethod()
    {
        $passwordHashing = $GLOBALS['TYPO3_CONF_VARS']['FE']['passwordHashing']['className'];

        switch ($passwordHashing) {
            case 'TYPO3\CMS\Core\Crypto\PasswordHashing\Argon2iPasswordHash':
                return 'Argon2i';
                break;

            case 'TYPO3\CMS\Core\Crypto\PasswordHashing\Argon2idPasswordHash':
                return 'Argon2id';
                break;

            case 'TYPO3\CMS\Core\Crypto\PasswordHashing\BcryptPasswordHash':
                return 'Bcrypt';
                break;

            case 'TYPO3\CMS\Core\Crypto\PasswordHashing\Pbkdf2PasswordHash':
                return 'Pbkdf2';
                break;

            case 'TYPO3\CMS\Core\Crypto\PasswordHashing\PhpassPasswordHash':
                return 'Phpass';
                break;

            default:
                return 'Argon2i';
        }
    }
}
