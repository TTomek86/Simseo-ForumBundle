<?php

namespace Simseo\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SimseoForumBundle:Default:index.html.twig');
    }
}
