<?php

namespace Simseo\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Category
 *
 * @ORM\Table(name="simseo_forum_category")
 * @ORM\Entity(repositoryClass="Gedmo\Sortable\Entity\Repository\SortableRepository")
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;
    
    /**
     * @var array
     * 
     * @ORM\OneToMany(targetEntity="Simseo\ForumBundle\Entity\Forum", mappedBy="category", cascade={"remove"})
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $forums;
    
    /**
     * @var int
     * 
     * @Gedmo\SortablePosition
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    public function __construct() 
    {
        $this->forums = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Category
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * Add forum
     * 
     * @param \Simseo\ForumBundle\Entity\Forum $forum
     * @return Category
     */
    public function addForum(\Simseo\ForumBundle\Entity\Forum $forum)
    {
        $this->forums[] = $forum;
        return $this;
    }
    
    /**
     * Remove forum
     * 
     * @param \Simseo\ForumBundle\Entity\Forum $forum
     * @return Category
     */
    public function removeForum(\Simseo\ForumBundle\Entity\Forum $forum)
    {
        $this->forums->removeElement($forum);
        return $this;
    }
    
    /**
     * Get forums
     * 
     * @return ArrayCollection()
     */
    public function getForums()
    {
        return $this->forums;
    }
    
    /**
     * Set position
     * 
     * @param integer $position
     * @return Category
     */
    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }
    
    /**
     * Get position
     * 
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }
}

