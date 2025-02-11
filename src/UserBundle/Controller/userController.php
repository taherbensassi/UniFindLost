<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;


class userController extends Controller
{


    /**
     * @Route("/{category}/{userId}/Profile",name="Profile_user_connect")
     */
    public function indexAction($category,$userId)
    {
        $em = $this->getDoctrine()->getManager();

        /******* get the customer *****/
        $users = $em->getRepository('adminBundle:User')->findOneBy(array(
            'username'=>$userId
        ));
        $userConnectId = $this->get('security.token_storage')->getToken()->getUser();
        //$userConnect = $em->getRepository('adminBundle:User')->find($userConnectId);
        $foundItem = $em->getRepository('adminBundle:found_itemes')->findBy(array(
            'user'=>$userConnectId
        ));


        return $this->render('userBundle/Profile/user_profile.html.twig',array(
            'user' => $users,
            'category' => $category,
            'found_itemes' => $foundItem,


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

        $information = $em->getRepository('adminBundle:information_customer')->findBy(array(
            'user'=>$users
        ));

        return $this->render('userBundle/index/information.html.twig',array(
            'user' => $users,
            'category' => $category,
            'information' => $information,



        ));
    }





}
