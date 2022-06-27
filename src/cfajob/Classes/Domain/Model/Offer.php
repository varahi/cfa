<?php
namespace T3Dev\Cfajob\Domain\Model;

use TYPO3\CMS\Extbase\Annotation as Extbase;

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
 * Offer
 */
class Offer extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * @var integer
     */
    protected $uid;

    /**
     * @var bool
     */
    protected $hidden;

    /**
     * @var \DateTime
     */
    protected $crdate = null;

    /**
     * name
     *
     * @var string
     * @Extbase\Validate("NotEmpty")
     */
    protected $name = '';

    /**
     * description
     *
     * @var string
     * @Extbase\Validate("NotEmpty")
     */
    protected $description = '';

    /**
     * email
     *
     * @var string
     * @Extbase\Validate("EmailAddress")
     * @Extbase\Validate("NotEmpty")
     */
    protected $email = '';

    /**
     * contactPerson
     *
     * @var string
     */
    protected $contactPerson = '';

    /**
     * site
     *
     * @var string
     */
    protected $site = '';

    /**
     * phone
     *
     * @var string
     * @Extbase\Validate("NotEmpty")
     */
    protected $phone = '';

    /**
     * type
     *
     * @var \T3Dev\Cfajob\Domain\Model\Position
     */
    protected $type = null;

    /**
     * city
     *
     * @var \T3Dev\Cfajob\Domain\Model\Location
     */
    protected $city = null;

    /**
     * zip
     *
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("Number")
     * @Extbase\Validate("NotEmpty")
     */
    protected $zip = '';

    /**
     * company
     *
     * @var \T3Dev\Cfajob\Domain\Model\FrontendUser
     */
    protected $company = null;

    /**
     * company
     *
     * @var \T3Dev\Cfajob\Domain\Model\FrontendUser
     */
    protected $frontenduser = null;

    /**
     * @return int
     */
    public function getUid(): int
    {
        return $this->uid;
    }

    /**
     * @param int $uid
     */
    public function setUid(int $uid): void
    {
        $this->uid = $uid;
    }

    /**
     * @return bool
     */
    public function isHidden()
    {
        return $this->hidden;
    }

    /**
     * @param bool $hidden
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
    }

    /**
     * Returns the creation date
     *
     * @return \DateTime $crdate
     */
    public function getCrdate()
    {
        return $this->crdate;
    }

    /**
     * Returns the name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Returns the email
     *
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets the email
     *
     * @param string $email
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Returns the contactPerson
     *
     * @return string $contactPerson
     */
    public function getContactPerson()
    {
        return $this->contactPerson;
    }

    /**
     * Sets the contactPerson
     *
     * @param string $contactPerson
     * @return void
     */
    public function setContactPerson($contactPerson)
    {
        $this->contactPerson = $contactPerson;
    }

    /**
     * Returns the site
     *
     * @return string $site
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Sets the site
     *
     * @param string $site
     * @return void
     */
    public function setSite($site)
    {
        $this->site = $site;
    }

    /**
     * Returns the phone
     *
     * @return string $phone
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Sets the phone
     *
     * @param string $phone
     * @return void
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * Returns the type
     *
     * @return \T3Dev\Cfajob\Domain\Model\Position $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the type
     *
     * @param \T3Dev\Cfajob\Domain\Model\Position $type
     * @return void
     */
    public function setType(\T3Dev\Cfajob\Domain\Model\Position $type)
    {
        $this->type = $type;
    }

    /**
     * Returns the city
     *
     * @return \T3Dev\Cfajob\Domain\Model\Location $city
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Sets the city
     *
     * @param \T3Dev\Cfajob\Domain\Model\Location $city
     * @return void
     */
    public function setCity(\T3Dev\Cfajob\Domain\Model\Location $city)
    {
        $this->city = $city;
    }

    /**
     * Returns the zip
     *
     * @return string $zip
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Sets the zip
     *
     * @param string $zip
     * @return void
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    /**
     * Returns the company
     *
     * @return \T3Dev\Cfajob\Domain\Model\FrontendUser $company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Sets the company
     *
     * @param \T3Dev\Cfajob\Domain\Model\FrontendUser $company
     * @return void
     */
    public function setCompany(\T3Dev\Cfajob\Domain\Model\FrontendUser $company)
    {
        $this->company = $company;
    }

    /**
     * @return FrontendUser
     */
    public function getFrontenduser(): ?FrontendUser
    {
        return $this->frontenduser;
    }

    /**
     * Sets the frontenduser
     *
     * @param \T3Dev\Cfajob\Domain\Model\FrontendUser $frontenduser
     * @return void
     */
    public function setFrontenduser(\T3Dev\Cfajob\Domain\Model\FrontendUser $frontenduser)
    {
        $this->frontenduser = $frontenduser;
    }
}
