<?php

namespace Pashedu\CompanyBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Company
 *
 * @ORM\Table(name="company")
 * @ORM\Entity(repositoryClass="Pashedu\CompanyBundle\Repository\CompanyRepository")
 */
class Company
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="Urltosite", type="string", length=255, nullable=true)
     * @Assert\Url(
     * message = "Enter proper Url"
     * )
     */
    private $urltosite;

    /**
     * @ORM\OneToMany(targetEntity="Worker", mappedBy="company")
     */
    private $workers;

    /**
     * @ORM\OneToMany(targetEntity="Office", mappedBy="company")
     */
    private $offices;

    /**
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Company
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Company
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Company
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set urltosite
     *
     * @param string $urltosite
     * @return Company
     */
    public function setUrltosite($urltosite)
    {
        $this->urltosite = $urltosite;

        return $this;
    }

    /**
     * Get urltosite
     *
     * @return string 
     */
    public function getUrltosite()
    {
        return $this->urltosite;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->workers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->offices = new \Doctrine\Common\Collections\ArrayCollection();
    }

    //ToString

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->name;
    }

    /**
     * Add workers
     *
     * @param \Pashedu\CompanyBundle\Entity\Office $workers
     * @return Company
     */
    public function addWorker(\Pashedu\CompanyBundle\Entity\Office $workers)
    {
        $this->workers[] = $workers;

        return $this;
    }

    /**
     * Remove workers
     *
     * @param \Pashedu\CompanyBundle\Entity\Office $workers
     */
    public function removeWorker(\Pashedu\CompanyBundle\Entity\Office $workers)
    {
        $this->workers->removeElement($workers);
    }

    /**
     * Get workers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getWorkers()
    {
        return $this->workers;
    }

    /**
     * Add offices
     *
     * @param \Pashedu\CompanyBundle\Entity\Office $offices
     * @return Company
     */
    public function addOffice(\Pashedu\CompanyBundle\Entity\Office $offices)
    {
        $this->offices[] = $offices;

        return $this;
    }

    /**
     * Remove offices
     *
     * @param \Pashedu\CompanyBundle\Entity\Office $offices
     */
    public function removeOffice(\Pashedu\CompanyBundle\Entity\Office $offices)
    {
        $this->offices->removeElement($offices);
    }

    /**
     * Get offices
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOffices()
    {
        return $this->offices;
    }

    /**
     * Set category
     *
     * @param \Pashedu\CompanyBundle\Entity\Category $category
     * @return Company
     */
    public function setCategory(\Pashedu\CompanyBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Pashedu\CompanyBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
}
