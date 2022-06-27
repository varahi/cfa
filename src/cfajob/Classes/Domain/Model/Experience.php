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
 * Experience
 */
class Experience extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * employeur
     *
     * @var string
     */
    protected $employeur = '';

    /**
     * position
     *
     * @var string
     */
    protected $position = '';

    /**
     * startYear
     *
     * @var \DateTime
     */
    protected $startYear = null;

    /**
     * endYear
     *
     * @var \DateTime
     */
    protected $endYear = null;

    /**
     * description
     *
     * @var string
     */
    protected $description = '';

    /**
     * user
     *
     * @var \T3Dev\Cfajob\Domain\Model\FrontendUser
     */
    protected $user = null;

    /**
     * Returns the employeur
     *
     * @return string $employeur
     */
    public function getEmployeur()
    {
        return $this->employeur;
    }

    /**
     * Sets the employeur
     *
     * @param string $employeur
     * @return void
     */
    public function setEmployeur($employeur)
    {
        $this->employeur = $employeur;
    }

    /**
     * Returns the position
     *
     * @return string $position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Sets the position
     *
     * @param string $position
     * @return void
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * Returns the startYear
     *
     * @return \DateTime $startYear
     */
    public function getStartYear()
    {
        return $this->startYear;
    }

    /**
     * Sets the startYear
     *
     * @param \DateTime $startYear
     * @return void
     */
    public function setStartYear(\DateTime $startYear)
    {
        $this->startYear = $startYear;
    }

    /**
     * Returns the endYear
     *
     * @return \DateTime $endYear
     */
    public function getEndYear()
    {
        return $this->endYear;
    }

    /**
     * Sets the endYear
     *
     * @param \DateTime $endYear
     * @return void
     */
    public function setEndYear(\DateTime $endYear)
    {
        $this->endYear = $endYear;
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
     * Returns the user
     *
     * @return \T3Dev\Cfajob\Domain\Model\FrontendUser $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Sets the user
     *
     * @param \T3Dev\Cfajob\Domain\Model\FrontendUser $user
     * @return void
     */
    public function setUser(\T3Dev\Cfajob\Domain\Model\FrontendUser $user)
    {
        $this->user = $user;
    }
}
