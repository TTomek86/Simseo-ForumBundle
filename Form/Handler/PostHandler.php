<?php

namespace Simseo\ForumBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Simseo\ForumBundle\Entity\Post;
use Symfony\Component\Form\FormError;


class PostHandler
{
    
    protected $request;
    protected $form;
    protected $em;
    protected $post;
    protected $antiflood;
    
    
    /**
     * Initialize the handler with the Form and the Request
     * 
     * @param Form $form
     * @param Request $request
     * @param Post $post
     * @param $em
     */
    public function __construct(Form $form, Request $request, Post $post, $em, $antiflood = null)
    {
        $this->form = $form;
        $this->request = $request;
        $this->post = $post;
        $this->em = $em;
        $this->antiflood = $antiflood;
    }
    
    public function process()
    {
        if($this->request->isMethod('POST') && $this->form->handleRequest($this->request)->isValid())
        {
            if($this->antiflood && $this->antiflood->isFlood($this->post))
            {
                $this->form->addError(new FormError('vous ne pouvez pas poster de nouveau message sur ce topic avant'.$this->antiflood->getTime().'h'));
                return false;
            }
            $this->onSucess();
            return true;
        }
    }
    
    public function onSucess()
    {
        $this->em->persist($this->post);
        $this->em->flush();
    }
}