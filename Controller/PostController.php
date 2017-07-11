<?php

namespace Simseo\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Simseo\ForumBundle\Form\Type\PostEditType;
use Simseo\ForumBundle\Form\Handler\PostHandler;



class PostController extends Controller
{
    public function editAction(Request $request, \Simseo\ForumBundle\Entity\Post $post)
    {
        if($this->getUser() !== $post->getAuthor() && !$this->get('security.authorization_checker')->isGranted('ROLE_MODERATOR'))
        {
            throw $this->createAccessDeniedException();
        }
        
        $form = $this->createForm(PostEditType::class, $post);
        $formHandler = new PostHandler($form, $request, $post, $this->getDoctrine()->getManager());
        
        if($formHandler->process())
        {
            $this->get('session')->getFlashBag()->add('success', 'Votre post a bien été édité');
            return $this->redirectToRoute('simseo_forum_topic_show', array('slug' => $post->getTopic()->getSlug()));
        }
        
        return $this->render('SimseoForumBundle:Post:edit.html.twig', 
            array(
                'form' => $form->createView(),
            )
        );
    }
    /**
     * 
     * @Security("is_granted('ROLE_MODERATOR')")
     */
    public function removeAction(\Simseo\ForumBundle\Entity\Post $post)
    {
        $em = $this->getDoctrine()->getManager();
        $post->setContent('ce message a été supprimé par un modérateur à cause de son contenu non conforme aux règles du forum');
        $em->persist($post);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('success', 'Le post à bien été supprimé');
        return $this->redirectToRoute('simseo_forum_topic_show', array('slug' => $post->getTopic()->getSlug()));
    }
}
