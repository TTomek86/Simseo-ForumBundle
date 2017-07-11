<?php

namespace Simseo\ForumBundle\Form\Handler;

use Simseo\ForumBundle\Form\Handler\TopicHandler;


/**
 * Class TopicEditHandler
 *
 * @author Simon Cosandey <contact@simseo.ch>
 */
class TopicEditHandler extends TopicHandler {
    
    public function onSucess()
    {
        $this->em->persist($this->topic);
        $this->em->flush();
    }
}
