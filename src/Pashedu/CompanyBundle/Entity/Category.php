<?php

namespace Pashedu\CompanyBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="Pashedu\CompanyBundle\Repository\CategoryRepository")
 */
class Category
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
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     */
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;

    /**
     * @var string
     *
     * @ORM\Column(name="categoryname", type="string", length=255, unique=true)
     */
    private $categoryname;


    public function  __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->categoryname;
    }

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
     * Set categoryname
     *
     * @param string $categoryname
     * @return Category
     */
    public function setCategoryname($categoryname)
    {
        $this->categoryname = $categoryname;

        return $this;
    }

    /**
     * Get categoryname
     *
     * @return string 
     */
    public function getCategoryname()
    {
        return $this->categoryname;
    }

    /**
     * Add children
     *
     * @param \Pashedu\CompanyBundle\Entity\Category $children
     * @return Category
     */
    public function addChild(\Pashedu\CompanyBundle\Entity\Category $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \Pashedu\CompanyBundle\Entity\Category $children
     */
    public function removeChild(\Pashedu\CompanyBundle\Entity\Category $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param \Pashedu\CompanyBundle\Entity\Category $parent
     * @return Category
     */
    public function setParent(\Pashedu\CompanyBundle\Entity\Category $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Pashedu\CompanyBundle\Entity\Category 
     */
    public function getParent()
    {
        return $this->parent;
    }
}
