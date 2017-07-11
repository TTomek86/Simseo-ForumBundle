<?php

namespace Simseo\ForumBundle\Component;

use Simseo\ForumBundle\Entity\Post;

/**
 * Class Antiflood
 *
 * @author Simon Cosandey <contact@simseo.ch>
 */
class Antiflood {
    protected $securityTokenStorage;
    protected $time;
    protected $antifloodEnabled;
       
    public function __construct($securityTokenStorage, $antifloodEnabled, $time)
    {
        $this->securityTokenStorage = $securityTokenStorage;
        $this->time = $time;
        $this->antifloodEnabled = $antifloodEnabled;
    }
    
    public function isFlood(Post $post)
    {

        $topic = $post->getTopic();
        
        if($this->antifloodEnabled
            && $topic->getPosts()->last()->getAuthor() === $this->securityTokenStorage->getToken()->getUser()
            && (array) $topic->getLastPost()->diff(new \Datetime) < (array) new \DateInterval('P0DT'.$this->time.'H')
        ){
            return true;
        }
        return false;
    }
    
    public function getTime()
    {
        return $this->time;
    }
}
