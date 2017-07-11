<?php

namespace Simseo\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @author Simon Cosandey <contact@simseo.ch>
 * 
 * Class ForumController
 */
class ForumController extends Controller
{
    /**
     * Add Forum
     * 
     * @Security("is_granted('ROLE_MODERATOR')")
     */
    public function addAction()
    {
        return $this->render('SimseoForumBundle:Default:index.html.twig');
    }
    
    /**
     * Edit Forum
     * 
     * @Security("is_granted('ROLE_MODERATOR')")
     */
    public function editAction()
    {
        return $this->render('SimseoForumBundle:Default:index.html.twig');
    } 
    
    /**
     * Remove Forum
     * 
     * @Security("is_granted('ROLE_MODERATOR')")
     */
    public function removeAction()
    {
        return $this->render('SimseoForumBundle:Default:index.html.twig');
    }
    
    /**
     * Move up Forum position
     * 
     * @Security("is_granted('ROLE_MODERATOR')")
     */
    public function moveUpAction()
    {
        return $this->render('SimseoForumBundle:Default:index.html.twig');
    }

    /**
     * Move down Forum position
     * 
     * @Security("is_granted('ROLE_MODERATOR')")
     */    
    public function moveDownAction()
    {
        return $this->render('SimseoForumBundle:Default:index.html.twig');
    }
    
    /**
     * Index page, list the categories and forums 
     */
    public function listAction()
    {
        $categories = $this->getDoctrine()->getManager()->getRepository('SimseoForumBundle:Category')->findBy(
            array(),
            array('position' => 'asc'),
            null,
            null
        );
        
        return $this->render('SimseoForumBundle:Forum:list.html.twig', 
            array(
                'categories' => $categories,
            )
        );
    }
    
    /**
     * Show the Topics in the selected Forum
     */
    public function showAction(\Simseo\ForumBundle\Entity\Forum $forum)
    {
        $pagination = $this->get('simseo.forum.pagin')->paginate('topics', $forum->getTopics());
        return $this->render('SimseoForumBundle:Forum:show.html.twig', 
            array(
                'forum' => $forum,
                'pagination' => $pagination,
            )
        );
    }
}
