<?php

namespace Simseo\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Forum
 *
 * @ORM\Table(name="simseo_forum_forum")
 * @ORM\Entity(repositoryClass="Gedmo\Sortable\Entity\Repository\SortableRepository")
 */
class Forum
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
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=500)
     */
    private $description;
    
    /**
     * @Gedmo\SortablePosition
     * @ORM\Column(name="position", type="integer")
     */
    private $position;
    
    /**
     *
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;
    
    /**
     *
     * @ORM\OneToOne(targetEntity="Sonata\MediaBundle\Model\MediaInterface")
     * @ORM\JoinColumn(nullable=true)
     */
    private $image;

    /**
     * @Gedmo\SortableGroup
     * @ORM\ManyToOne(targetEntity="Simseo\ForumBundle\Entity\Category", inversedBy="forums")
     */
    private $category;
    
    /**
     * @ORM\OneToMany(targetEntity="Simseo\ForumBundle\Entity\Topic", mappedBy="forum", cascade={"remove"})
     * @ORM\OrderBy({"lastPost" = "DESC"})
     */
    private $topics;


    public function __construct() {
        $this->topics = new ArrayCollection();
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
     * @return Forum
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
     * Set description
     *
     * @param string $description
     *
     * @return Forum
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
     * Set position
     * 
     * @param integer $position
     * @return Forum
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
    
    /**
     * Get slug
     * 
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
    
    /**
     * Set image
     * 
     * @param \Sonata\MediaBundle\Model\MediaInterface $image
     * @return Forum
     */
    public function setImage(\Sonata\MediaBundle\Model\MediaInterface $image)
    {
        $this->image = $image;
        return $this;
    }
    
    /**
     * Get image
     * 
     * @return \Sonata\MediaBundle\Model\MediaInterface
     */
    public function getImage()
    {
        return $this->image;
    }
    
    /**
     * Set category
     *
     * @param Simseo\ForumBundle\Entity\Category $category
     *
     * @return Forum
     */
    public function setCategory(\Simseo\ForumBundle\Entity\Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return Simseo\ForumBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }
    
    /**
     * Add topic
     * 
     * @param \Simseo\ForumBundle\Entity\Topic $topic
     * @return Forum
     */
    public function addTopic(\Simseo\ForumBundle\Entity\Topic $topic)
    {
        $this->topics[] = $topic;
        return $this;
    }
    
    /**
     * Remove topic
     * 
     * @param \Simseo\ForumBundle\Entity\Topic $topic
     * @return Forum
     */
    public function removeTopic(\Simseo\ForumBundle\Entity\Topic $topic)
    {
        $this->topics->removeElement($topic);
        return $this;
    }
    
    /**
     * Get topics
     * 
     * @return ArrayCollection
     */
    public function getTopics()
    {
        return $this->topics;
    }
}

