<?php

namespace UserBundle\Controller;

use adminBundle\Entity\categorie_user;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class userController extends Controller
{


    /**
     * @Route("/{category}/{userId}/Profile",name="Profile_user_connect")
     */
    public function indexAction($category,$userId)
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('adminBundle:User')->findOneBy(array(
            'username'=>$userId
        ));

        return $this->render('userBundle/index/user_profile.html.twig',array(
            'user' => $users,
            'category' => $category,


        ));
    }

    /**
     * @Route("/{category}/{userId}/information",name="information_user")
     */
    public function informationAction($category,$userId)
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('adminBundle:User')->findOneBy(array(
            'username'=>$userId
        ));

        return $this->render('userBundle/index/information.html.twig',array(
            'user' => $users,
            'category' => $category,


        ));
    }





}
