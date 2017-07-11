<?php

namespace Simseo\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AdminController extends Controller
{
    /**
     * forum admin dashboard
     * @Security("is_granted('ROLE_MODERATOR')")
     */
    public function indexAction()
    {
        if($this->container->getParameter('simseo_forum.sonata_admin'))
        {
            return $this->redirectToRoute('sonata_admin_dashboard');
        }
        $categories = $this->getDoctrine()->getManager()->getRepository('SimseoForumBundle:Category')->findBy(
                array(),
                array('position' => 'ASC'),
                null,
                null
            );
        
        return $this->render('SimseoForumBundle:Admin:dashboard.html.twig', array(
            'categories' => $categories,
        ));
    }
}
