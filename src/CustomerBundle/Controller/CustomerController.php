<?php

namespace CustomerBundle\Controller;

use adminBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * User controller.
 *
 * @Route("Customer")
 */
class CustomerController extends Controller
{
    /**
     * Lists all user entities.
     *
     * @Route("/dashboard", name="customer_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $sf_Users = $em->getRepository('adminBundle:User')->findAll();

        return $this->render('CustomerBundle/dashboard/dashboard.html.twig', array(
            'active'=>'users',
            'users'=>$sf_Users,

        ));
    }




}
