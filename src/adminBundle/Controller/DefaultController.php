<?php

namespace adminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/administration/dashboard/",name="dashboard",options={"expose"=true})
     */
    public function indexAction()
    {
        return $this->render('adminBundle/dashboard/dashboard.html.twig');
    }


    /**
     * @Route("/lockscreen/",name="lockscreen")
     */
    public function lockscreenAction()
    {
        $em = $this->getDoctrine()->getManager();

        $result = $em->getRepository("adminBundle:User")->createQueryBuilder('U')
            ->addOrderBy('U.lastLogin', 'DESC')
            ->getQuery()
            ->getResult();



        return $this->render('adminBundle/logout_handler.html.twig/session_time_out.html.twig',array(
            'lastsessionlogin'=>$result
        ));
    }
}
