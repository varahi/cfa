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
 * Category
 */
class Category extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * title
     *
     * @var string
     */
    protected $title = '';

    /**
     * description
     *
     * @var string
     */
    protected $description = '';

    /**
     * @var \T3Dev\Cfajob\Domain\Model\Category
     * @Extbase\ORM\Lazy
     */
    protected $parentcategory;

    /**
     * link
     *
     * @var string
     */
    protected $link = '';

    /**
     * item
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3Dev\Cfajob\Domain\Model\Training>
     */
    protected $item = null;

    /**
     * images
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $images = null;

    /**
     * id
     *
     * @var int
     */
    protected $id = 0;

    /**
     * type
     *
     * @var int
     */
    protected $type = 0;

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
        $this->item = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
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
     * Get parent category
     *
     * @return \T3Dev\Cfajob\Domain\Model\Category
     */
    public function getParentcategory()
    {
        return $this->parentcategory;
    }

    /**
     * Set parent category
     *
     * @param \T3Dev\Cfajob\Domain\Model\Category $category parent category
     */
    public function setParentcategory(self $category)
    {
        $this->parentcategory = $category;
    }


    /**
     * Returns the link
     *
     * @return string $link
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Sets the link
     *
     * @param string $link
     * @return void
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * Adds a Item
     *
     * @param \T3Dev\Cfajob\Domain\Model\Training $item
     * @return void
     */
    public function addItem(\T3Dev\Cfajob\Domain\Model\Training $item)
    {
        $this->item->attach($item);
    }

    /**
     * Removes a Item
     *
     * @param \T3Dev\Cfajob\Domain\Model\Training $itemToRemove The Item to be removed
     * @return void
     */
    public function removeItem(\T3Dev\Cfajob\Domain\Model\Training $itemToRemove)
    {
        $this->item->detach($itemToRemove);
    }

    /**
     * Returns the item
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\T3Dev\Cfajob\Domain\Model\Training> $item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Sets the item
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $item
     * @return void
     */
    public function setItem(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $item)
    {
        $this->item = $item;
    }

    /**
     * Returns the images
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $images
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Sets the images
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $images
     * @return void
     */
    public function setImages(\TYPO3\CMS\Extbase\Domain\Model\FileReference $images)
    {
        $this->images = $images;
    }

    /**
     * Returns the id
     *
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the id
     *
     * @param int $id
     * @return void
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
}
