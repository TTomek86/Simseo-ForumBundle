<?php

namespace Simseo\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Simseo\ForumBundle\Entity\Topic;
use Simseo\ForumBundle\Form\Type\TopicType;
use Simseo\ForumBundle\Form\Type\TopicEditType;
use Simseo\ForumBundle\Form\Handler\TopicHandler;
use Simseo\ForumBundle\Form\Handler\TopicEditHandler;
use Simseo\ForumBundle\Entity\Post;
use Simseo\ForumBundle\Form\Handler\PostHandler;
use Simseo\ForumBundle\Form\Type\PostType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @author Simon Cosandey <contact@simseo.ch>
 * 
 * Class TopicController
 */
class TopicController extends Controller
{
    
    /**
     * Add a new topic
     * 
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     */
    public function addAction(Request $request, \Simseo\ForumBundle\Entity\Forum $forum)
    {
        $topic = new Topic();
        $topic->setForum($forum);
        $form = $this->createForm(TopicType::class, $topic);
        $formHandler = new TopicHandler($form, $request, $topic, $this->getDoctrine()->getManager());
        
        if($formHandler->process())
        {
            $this->get('session')->getFlashBag()->add('success', 'Votre topic a bien été créé');
            return $this->redirectToRoute('simseo_forum_topic_show', array('slug' => $topic->getSlug()));
        }
        
        return $this->render('SimseoForumBundle:Topic:add.html.twig', 
            array(
                'form' => $form->createView(),
            )
        );
    }
    
    /**
     * Edit a topic
     * 
     * @Security("is_granted('ROLE_MODERATOR')")
     */
    public function editAction(Simseo\ForumBundle\Entity\Topic $topic)
    {   
        $form = $this->createForm(TopicEditType::class, $topic);
        $formHandler = new TopicEditHandler($form, $request, $topic, $this->getDoctrine()->getManager());
        
        if($formHandler->process())
        {
            $this->get('session')->getFlashBag()->add('success', 'Le topic a bien été édité');
            return $this->redirectToRoute('simseo_forum_topic_show', array('slug' => $topic->getSlug()));
        }
        
        return $this->render('SimseoForumBundle:Topic:edit.html.twig',
            array(
               'form' => $form->createView(), 
            )
        );
    } 
    
    public function removeAction()
    {
        return $this->render('SimseoForumBundle:Default:index.html.twig');
    }
    
    public function lockToggleAction()
    {
        return $this->render('SimseoForumBundle:Default:index.html.twig');
    }

    public function resolveToggleAction()
    {
        return $this->render('SimseoForumBundle:Default:index.html.twig');
    }

    public function pinnToggleAction()
    {
        return $this->render('SimseoForumBundle:Default:index.html.twig');
    }
    
    public function showAction(Request $request, \Simseo\ForumBundle\Entity\Topic $topic)
    {
        $post = new Post();
        $post->setTopic($topic);
        $form = $this->createForm(PostType::class, $post);
        $formHandler = new PostHandler($form, $request, $post, $this->getDoctrine()->getManager());
        
        if($formHandler->process())
        {
            $this->get('session')->getFlashBag()->add('success', 'Votre post a bien été ajoutée');
            return $this->redirectToRoute('simseo_forum_topic_show', array('slug' => $topic->getSlug()));
        }
        
        $pagination = $this->get('simseo.forum.pagin')->paginate('posts', $topic->getPosts());
        return $this->render('SimseoForumBundle:Topic:show.html.twig', 
            array(
                'topic' => $topic,
                'pagination' => $pagination,
                'form' => $form->createView(),
            )
        );
    }
}
