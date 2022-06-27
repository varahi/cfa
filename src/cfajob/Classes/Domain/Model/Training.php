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
 * Training
 */
class Training extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * name
     *
     * @var string
     */
    protected $name = '';

    /**
     * isDpc
     *
     * @var bool
     */
    protected $isDpc = false;

    /**
     * isNew
     *
     * @var bool
     */
    protected $isNew = false;

    /**
     * information
     *
     * @var string
     */
    protected $information = '';

    /**
     * duration
     *
     * @var string
     */
    protected $duration = '';

    /**
     * whois
     *
     * @var string
     */
    protected $whois = '';

    /**
     * whoare
     *
     * @var string
     */
    protected $whoare = '';

    /**
     * courseFile
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @Extbase\ORM\Cascade ("remove")
     */
    protected $courseFile = '';

    /**
     * registrationFile
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @Extbase\ORM\Cascade ("remove")
     */
    protected $registrationFile = '';

    /**
     * image
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @Extbase\ORM\Cascade ("remove")
     */
    protected $image = null;

    /**
     * programm
     *
     * @var string
     */
    protected $programm = '';

    /**
     * additionalInfo
     *
     * @var string
     */
    protected $additionalInfo = '';

    /**
     * city
     *
     * @var \T3Dev\Cfajob\Domain\Model\Location
     */
    protected $city = null;

    /**
     * categories
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3Dev\Cfajob\Domain\Model\Category>
     */
    protected $categories = null;

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
        $this->categories = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
     * Returns the isDpc
     *
     * @return bool $isDpc
     */
    public function getIsDpc()
    {
        return $this->isDpc;
    }

    /**
     * Sets the isDpc
     *
     * @param bool $isDpc
     * @return void
     */
    public function setIsDpc($isDpc)
    {
        $this->isDpc = $isDpc;
    }

    /**
     * Returns the boolean state of isDpc
     *
     * @return bool
     */
    public function isIsDpc()
    {
        return $this->isDpc;
    }

    /**
     * Returns the isNew
     *
     * @return bool $isNew
     */
    public function getIsNew()
    {
        return $this->isNew;
    }

    /**
     * Sets the isNew
     *
     * @param bool $isNew
     * @return void
     */
    public function setIsNew($isNew)
    {
        $this->isNew = $isNew;
    }

    /**
     * Returns the boolean state of isNew
     *
     * @return bool
     */
    public function isIsNew()
    {
        return $this->isNew;
    }

    /**
     * Returns the information
     *
     * @return string $information
     */
    public function getInformation()
    {
        return $this->information;
    }

    /**
     * Sets the information
     *
     * @param string $information
     * @return void
     */
    public function setInformation($information)
    {
        $this->information = $information;
    }

    /**
     * Returns the duration
     *
     * @return string $duration
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Sets the duration
     *
     * @param string $duration
     * @return void
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    /**
     * Returns the whois
     *
     * @return string $whois
     */
    public function getWhois()
    {
        return $this->whois;
    }

    /**
     * Sets the whois
     *
     * @param string $whois
     * @return void
     */
    public function setWhois($whois)
    {
        $this->whois = $whois;
    }

    /**
     * Returns the whoare
     *
     * @return string $whoare
     */
    public function getWhoare()
    {
        return $this->whoare;
    }

    /**
     * Sets the whoare
     *
     * @param string $whoare
     * @return void
     */
    public function setWhoare($whoare)
    {
        $this->whoare = $whoare;
    }

    /**
     * Returns the programm
     *
     * @return string $programm
     */
    public function getProgramm()
    {
        return $this->programm;
    }

    /**
     * Sets the programm
     *
     * @param string $programm
     * @return void
     */
    public function setProgramm($programm)
    {
        $this->programm = $programm;
    }

    /**
     * Returns the additionalInfo
     *
     * @return string $additionalInfo
     */
    public function getAdditionalInfo()
    {
        return $this->additionalInfo;
    }

    /**
     * Sets the additionalInfo
     *
     * @param string $additionalInfo
     * @return void
     */
    public function setAdditionalInfo($additionalInfo)
    {
        $this->additionalInfo = $additionalInfo;
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
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    public function getCourseFile()
    {
        return $this->courseFile;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $courseFile
     */
    public function setCourseFile($courseFile)
    {
        $this->courseFile = $courseFile;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    public function getRegistrationFile()
    {
        return $this->registrationFile;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $registrationFile
     */
    public function setRegistrationFile($registrationFile)
    {
        $this->registrationFile = $registrationFile;
    }

    /**
     * Adds a Category
     *
     * @param \T3Dev\Cfajob\Domain\Model\Category $category
     * @return void
     */
    public function addCategory(\T3Dev\Cfajob\Domain\Model\Category $category)
    {
        $this->categories->attach($category);
    }

    /**
     * Removes a Category
     *
     * @param \T3Dev\Cfajob\Domain\Model\Category $categoryToRemove The Category to be removed
     * @return void
     */
    public function removeCategory(\T3Dev\Cfajob\Domain\Model\Category $categoryToRemove)
    {
        $this->categories->detach($categoryToRemove);
    }

    /**
     * Returns the categories
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3Dev\Cfajob\Domain\Model\Category> $categories
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Sets the categories
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3Dev\Cfajob\Domain\Model\Category> $categories
     * @return void
     */
    public function setCategories(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $categories)
    {
        $this->categories = $categories;
    }

    /**
     * Returns the image
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Sets the image
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     * @return void
     */
    public function setImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $image)
    {
        $this->image = $image;
    }
}
