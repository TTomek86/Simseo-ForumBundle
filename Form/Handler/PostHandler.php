<?php

namespace Simseo\ForumBundle\Form\Handler;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Simseo\ForumBundle\Entity\Post;


class PostHandler
{
    
    protected $request;
    protected $form;
    protected $em;
    protected $post;
    
    
    /**
     * Initialize the handler with the Form and the Request
     * 
     * @param Form $form
     * @param Request $request
     * @param Post $post
     * @param $em
     */
    public function __construct(Form $form, Request $request, Post $post, $em)
    {
        $this->form = $form;
        $this->request = $request;
        $this->post = $post;
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
        $this->em->persist($this->post);
        $this->em->flush();
    }
}