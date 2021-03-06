<?php

namespace Simseo\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Topic
 *
 * @ORM\Table(name="simseo_forum_topic")
 * @ORM\Entity(repositoryClass="Simseo\ForumBundle\Repository\TopicRepository")
 */
class Topic
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;
    
    /**
     *
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;
    
    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="createdAt", type="datetimetz")
     */
    private $createdAt;

    /**
     * @Gedmo\Blameable(on="create")
     * @ORM\ManyToOne(targetEntity="Symfony\Component\Security\Core\User\UserInterface")
     */
    private $author;
    
    /**
     * @ORM\ManyToOne(targetEntity="Simseo\ForumBundle\Entity\Forum", inversedBy="topics")
     */
    private $forum;
    
    /**
     *
     * @ORM\OneToMany(targetEntity="Simseo\ForumBundle\Entity\Post", mappedBy="topic", cascade={"remove"})
     */
    private $posts;
    

    /**
     * @var bool
     *
     * @ORM\Column(name="locked", type="boolean")
     */
    private $locked = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="resolved", type="boolean")
     */
    private $resolved = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="pinned", type="boolean")
     */
    private $pinned = false;
    
    /**
     *
     * @ORM\Column(name="last_post", type="datetime")
     */
    private $lastPost;


    public function __construct() {
        $this->posts = new ArrayCollection();
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
     * @return Topic
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
     * Get slug
     * 
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Get author
     *
     * @return Symfony\Component\Security\Core\User\UserInterface
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set forum
     * 
     * @param \Simseo\ForumBundle\Entity\Forum $forum
     * @return Topic
     */
    public function setForum(\Simseo\ForumBundle\Entity\Forum $forum)
    {
        $this->forum = $forum;
        return $this;
    }
    
    /**
     * Get forum
     * 
     * @return \Simseo\ForumBundle\Entity\Forum
     */
    public function getForum()
    {
        return $this->forum;
    }
    
    /**
     * Add post 
     * 
     * @param \Simseo\ForumBundle\Entity\Post $post
     * @return Topic
     */
    public function addPost(\Simseo\ForumBundle\Entity\Post $post)
    {
        $this->posts[] = $post;
        return $this;
    }
    
    /**
     * Remove post 
     * 
     * @param \Simseo\ForumBundle\Entity\Post $post
     * @return Topic
     */
    public function removePost(\Simseo\ForumBundle\Entity\Post $post)
    {
        $this->posts->removeElement($post);
        return $this;
    }
    
    /**
     * Get posts
     * 
     * @return ArrayCollection
     */
    public function getPosts()
    {
        return $this->posts;
    }
  
    /**
     * Set locked
     *
     * @param boolean $locked
     *
     * @return Topic
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;

        return $this;
    }

    /**
     * Get locked
     *
     * @return bool
     */
    public function isLocked()
    {
        return $this->locked;
    }

    /**
     * Set resolved
     *
     * @param boolean $resolved
     *
     * @return Topic
     */
    public function setResolved($resolved)
    {
        $this->resolved = $resolved;

        return $this;
    }

    /**
     * Get resolved
     *
     * @return bool
     */
    public function isResolved()
    {
        return $this->resolved;
    }

    /**
     * Set pinned
     *
     * @param boolean $pinned
     *
     * @return Topic
     */
    public function setPinned($pinned)
    {
        $this->pinned = $pinned;

        return $this;
    }

    /**
     * Get pinned
     *
     * @return bool
     */
    public function isPinned()
    {
        return $this->pinned;
    }
    
    /**
     * Set lastPost
     * 
     * @param \Datetime $lastpost
     * @return Topic
     */
    public function setLastPost($lastpost)
    {
        $this->lastPost = $lastpost;
        return $this;
    }
    
    /**
     * Get lastPost
     * 
     * @return \Datetime
     */
    public function getLastPost()
    {
        return $this->lastPost;
    }
}

