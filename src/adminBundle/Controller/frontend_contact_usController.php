<?php

namespace adminBundle\Controller;

use adminBundle\Entity\frontend_contact_us;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Frontend_contact_us controller.
 *
 * @Route("frontend_contact_us")
 */
class frontend_contact_usController extends Controller
{
    /**
     * Lists all frontend_contact_us entities.
     *
     * @Route("/", name="frontend_contact_us_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $frontend_contact_uses = $em->getRepository('adminBundle:frontend_contact_us')->findAll();

        return $this->render('frontend_contact_us/index.html.twig', array(
            'frontend_contact_uses' => $frontend_contact_uses,
        ));
    }

    /**
     * Finds and displays a frontend_contact_us entity.
     *
     * @Route("/{id}", name="frontend_contact_us_show")
     * @Method("GET")
     */
    public function showAction(frontend_contact_us $frontend_contact_us)
    {

        return $this->render('frontend_contact_us/show.html.twig', array(
            'frontend_contact_us' => $frontend_contact_us,
        ));
    }
}
