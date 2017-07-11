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
    /**
     * 
     * @Security("is_granted('ROLE_MODERATOR')")
     */
    public function removeAction(\Simseo\ForumBundle\Entity\Topic $topic)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($topic);
        $em->flush();
        $this->get('session')->getFlashBag->add('success', 'le topic a bien été supprimé');
        return $this->redirectToRoute('simseo_forum_show', array('slug' => $topic->getForum()->getSlug()));
    }
    
    /**
     * Toggle locked/unlocked a topic
     * @Security("is_granted('ROLE_MODERATOR')")
     */
    public function lockToggleAction(\Simseo\ForumBundle\Entity\Topic $topic)
    {
        $em = $this->getDoctrine()->getManager();
        if($topic->isLocked())
        {
            $topic->setLocked(false);
            $this->get('session')->getFlashBag->add('success', 'le topic a bien été réouvert');
        }
        else{
            $topic->setLocked(true);
            $this->get('session')->getFlashBag->add('success', 'le topic a bien été fermé');
        }
        $em->persist($topic);
        $em->flush();
        return $this->redirectToRoute('simseo_forum_topic_show', array('slug' => $topic->getSlug()));
    }
    
    /**
     * Toggle resolved/unresolved a topic
     */
    public function resolveToggleAction(\Simseo\ForumBundle\Entity\Topic $topic)
    {
        if($this->getUser() !== $topic->getAuthor() && !$this->get('security.authorization_checker')->isGranted('ROLE_MODERATOR'))
        {
            throw $this->createAccessDeniedException();
        }
        $em = $this->getDoctrine()->getManager();
        if($topic->isResolved()){
            $topic->setResolved(false);
            $this->get('session')->getFlashBag->add('success', 'le topic a été marqué comme non résolu');
        }
        else{
            $topic->setResolved(true);
            $this->get('session')->getFlashBag->add('success', 'le topic a été marqué comme résolu');
        }
        $em->persist($topic);
        $em->flush();
        return $this->redirectToRoute('simseo_forum_topic_show', array('slug' => $topic->getSlug()));
    }
    /**
     * Toggle pinned/unpinned a topic
     * @Security("is_granted('ROLE_MODERATOR')")
     */
    public function pinnToggleAction(\Simseo\ForumBundle\Entity\Topic $topic)
    {
        $em = $this->getDoctrine()->getManager();
        if($topic->isPinned()){
            $topic->setPinned(false);
            $this->get('session')->getFlashBag->add('success', 'le topic a été desépinglé');
        }
        else{
            $topic->setPinned(true);
            $this->get('session')->getFlashBag->add('success', 'le topic a été épinglé');
        }
        $em->persist($topic);
        $em->flush();
        return $this->redirectToRoute('simseo_forum_topic_show', array('slug' => $topic->getSlug()));
    }
    
    /**
     * Show the posts for a selected topic
     */
    public function showAction(Request $request, \Simseo\ForumBundle\Entity\Topic $topic)
    {
        $post = new Post();
        $post->setTopic($topic);
        $form = $this->createForm(PostType::class, $post);
        $formHandler = new PostHandler($form, $request, $post, $this->getDoctrine()->getManager(), $this->get('simseo.forum.antiflood'));
        
        if($formHandler->process())
        {
            $this->get('session')->getFlashBag()->add('success', 'Votre post a bien été ajoutée');
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
