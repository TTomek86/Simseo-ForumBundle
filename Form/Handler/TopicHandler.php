<?php

namespace Simseo\ForumBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Simseo\ForumBundle\Entity\Post;
use Simseo\ForumBundle\Entity\Topic;


class TopicHandler
{
    
    protected $request;
    protected $form;
    protected $em;
    protected $topic;
    
    
    /**
     * Initialize the handler with the Form and the Request
     * 
     * @param Form $form
     * @param Request $request
     * @param Topic $topic
     * @param $em
     */
    public function __construct(Form $form, Request $request, Topic $topic, $em)
    {
        $this->form = $form;
        $this->request = $request;
        $this->topic = $topic;
        $this->em = $em;

    }
    
    public function process()
    {
        if($this->request->isMethod('POST') && $this->form->handleRequest($this->request)->isValid())
        {
            $this->onSucess();
            return true;
        }
    }
    
    public function onSucess()
    {
        $post = new Post();
        $post->setContent($this->form->get('content')->getData());
        $post->setTopic($this->topic);
        $this->em->persist($post);
        $this->em->persist($this->topic);
        $this->em->flush();
    }
}