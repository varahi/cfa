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

use TYPO3\CMS\Extbase\Annotation as Extbase;

/**
 * FrontendUser
 */
class FrontendUser extends \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
{

    /**
     * @var \DateTime
     */
    protected $crdate = null;

    /**
     * @var bool
     */
    protected $disable;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3Dev\Cfajob\Domain\Model\FrontendUserGroup>
     */
    protected $usergroup;

    /**
     * name
     *
     * @var string
     */
    protected $name = '';

    /**
     * firstName
     *
     * @var string
     */
    protected $firstName = '';

    /**
     * lastName
     *
     * @var string
     */
    protected $lastName = '';

    /**
     * titleCV
     *
     * @var string
     */
    protected $titleCV = '';

    /**
     * about
     *
     * @var string
     */
    protected $about = '';

    /**
     * diploma
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3Dev\Cfajob\Domain\Model\Diploma>
     * @Extbase\ORM\Cascade ("remove")
     */
    protected $diploma = null;

    /**
     * experience
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3Dev\Cfajob\Domain\Model\Experience>
     * @Extbase\ORM\Cascade ("remove")
     */
    protected $experience = null;

    /**
     * location
     *
     * @var \T3Dev\Cfajob\Domain\Model\Location
     */
    protected $location = null;

    /**
     * position
     *
     * @var \T3Dev\Cfajob\Domain\Model\Position
     */
    protected $position = null;

    /**
     * company
     *
     * @var string
     */
    protected $company = '';

    /**
     * contactPerson
     *
     * @var string
     */
    protected $contactPerson = '';

    /**
     * offer
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3Dev\Cfajob\Domain\Model\Offer>
     * @Extbase\ORM\Cascade ("remove")
     */
    protected $offer = null;

    /**
     * photo
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @Extbase\ORM\Cascade ("remove")
     */
    protected $photo = null;

    /**
     * cvfile
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @Extbase\ORM\Cascade ("remove")
     */
    protected $cvfile = null;

    /**
     * __construct
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
        $this->diploma = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->experience = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->offer = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->photo = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->cvfile = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
     * @param boolean $disable
     * @return FrontendUser
     */
    public function setDisable($disable)
    {
        $this->disable = $disable;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getDisable()
    {
        return $this->disable;
    }

    /**
     * Returns the usergroup
     *
     * @return string $usergroup
     */
    public function getUsergroup()
    {
        return $this->usergroup;
    }

    /**
     * Sets the usergroup
     *
     * @param string $usergroup
     * @return void
     */
    public function setUsergroup($usergroup)
    {
        $this->usergroup = $usergroup;
    }

    /**
     * Adds a Diploma
     *
     * @param \T3Dev\Cfajob\Domain\Model\Diploma $diploma
     * @return void
     */
    public function addDiploma(\T3Dev\Cfajob\Domain\Model\Diploma $diploma)
    {
        $this->diploma->attach($diploma);
    }

    /**
     * Removes a Diploma
     *
     * @param \T3Dev\Cfajob\Domain\Model\Diploma $diplomaToRemove The Diploma to be removed
     * @return void
     */
    public function removeDiploma(\T3Dev\Cfajob\Domain\Model\Diploma $diplomaToRemove)
    {
        $this->diploma->detach($diplomaToRemove);
    }

    /**
     * Returns the diploma
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3Dev\Cfajob\Domain\Model\Diploma> $diploma
     */
    public function getDiploma()
    {
        return $this->diploma;
    }

    /**
     * Sets the diploma
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3Dev\Cfajob\Domain\Model\Diploma> $diploma
     * @return void
     */
    public function setDiploma(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $diploma)
    {
        $this->diploma = $diploma;
    }

    /**
     * Adds a Experience
     *
     * @param \T3Dev\Cfajob\Domain\Model\Experience $experience
     * @return void
     */
    public function addExperience(\T3Dev\Cfajob\Domain\Model\Experience $experience)
    {
        $this->experience->attach($experience);
    }

    /**
     * Removes a Experience
     *
     * @param \T3Dev\Cfajob\Domain\Model\Experience $experienceToRemove The Experience to be removed
     * @return void
     */
    public function removeExperience(\T3Dev\Cfajob\Domain\Model\Experience $experienceToRemove)
    {
        $this->experience->detach($experienceToRemove);
    }

    /**
     * Returns the experience
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3Dev\Cfajob\Domain\Model\Experience> $experience
     */
    public function getExperience()
    {
        return $this->experience;
    }

    /**
     * Sets the experience
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3Dev\Cfajob\Domain\Model\Experience> $experience
     * @return void
     */
    public function setExperience(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $experience)
    {
        $this->experience = $experience;
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
     * Returns the firstName
     *
     * @return string $firstName
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Sets the firstName
     *
     * @param string $firstName
     * @return void
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * Returns the lastName
     *
     * @return string $lastName
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Sets the lastName
     *
     * @param string $lastName
     * @return void
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * Returns the titleCV
     *
     * @return string $titleCV
     */
    public function getTitleCV()
    {
        return $this->titleCV;
    }

    /**
     * Sets the titleCV
     *
     * @param string $titleCV
     * @return void
     */
    public function setTitleCV($titleCV)
    {
        $this->titleCV = $titleCV;
    }

    /**
     * Returns the about
     *
     * @return string $about
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * Sets the about
     *
     * @param string $about
     * @return void
     */
    public function setAbout($about)
    {
        $this->about = $about;
    }

    /**
     * Returns the location
     *
     * @return \T3Dev\Cfajob\Domain\Model\Location $location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Sets the location
     *
     * @param \T3Dev\Cfajob\Domain\Model\Location $location
     * @return void
     */
    public function setLocation(\T3Dev\Cfajob\Domain\Model\Location $location)
    {
        $this->location = $location;
    }

    /**
     * Returns the position
     *
     * @return \T3Dev\Cfajob\Domain\Model\Position $position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Sets the position
     *
     * @param \T3Dev\Cfajob\Domain\Model\Position $position
     * @return void
     */
    public function setPosition(\T3Dev\Cfajob\Domain\Model\Position $position)
    {
        $this->position = $position;
    }

    /**
     * Returns the company
     *
     * @return string $company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Sets the company
     *
     * @param string $company
     * @return void
     */
    public function setCompany($company)
    {
        $this->company = $company;
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
     * Adds a Offer
     *
     * @param \T3Dev\Cfajob\Domain\Model\Offer $offer
     * @return void
     */
    public function addOffer(\T3Dev\Cfajob\Domain\Model\Offer $offer)
    {
        $this->offer->attach($offer);
    }

    /**
     * Removes a Offer
     *
     * @param \T3Dev\Cfajob\Domain\Model\Offer $offerToRemove The Offer to be removed
     * @return void
     */
    public function removeOffer(\T3Dev\Cfajob\Domain\Model\Offer $offerToRemove)
    {
        $this->offer->detach($offerToRemove);
    }

    /**
     * Returns the offer
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3Dev\Cfajob\Domain\Model\Offer> $offer
     */
    public function getOffer()
    {
        return $this->offer;
    }

    /**
     * Sets the offer
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3Dev\Cfajob\Domain\Model\Offer> $offer
     * @return void
     */
    public function setOffer(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $offer)
    {
        $this->offer = $offer;
    }

    /**
     * Returns the photo
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference photo
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Sets the photo
     *
     * @param string $photo
     * @return void
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * Remove photo
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $photoToRemove Photo
     * @return void
     */
    public function removePhoto(\TYPO3\CMS\Extbase\Domain\Model\FileReference $photoToRemove)
    {
        $this->photo->detach($photoToRemove);
    }

    /**
     * Returns the cvfile
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference cvfile
     */
    public function getCvfile()
    {
        return $this->cvfile;
    }

    /**
     * Sets the cvfile
     *
     * @param string $cvfile
     * @return void
     */
    public function setCvfile($cvfile)
    {
        $this->cvfile = $cvfile;
    }

    /**
     * Remove cvfile
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $cvfileToRemove Cvfile
     * @return void
     */
    public function removeCvfile(\TYPO3\CMS\Extbase\Domain\Model\FileReference $cvfileToRemove)
    {
        $this->cvfile->detach($cvfileToRemove);
    }

    /**
     * Remove image
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $imageToRemove Photo
     * @return void
     */
    public function removeImage()
    {
        //$this->image = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }
}
