<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class indexController extends Controller
{


    /**
     * @Route("/index",name="homepage")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categorys = $em->getRepository('adminBundle:categorie_user')->findAll();
        $users = $em->getRepository('adminBundle:User')->findAll();



        return $this->render('MainFront/index/index.html.twig',array(
            'categorys'=>$categorys,
            'users'=>$users,
        ));
    }





    /**
     * @Route("/search/",name="search",methods={"GET"})
     */
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userId=$request->get('users');
        $user = $em->getRepository('adminBundle:User')->find($userId);
        $categorie_user = $em->getRepository('adminBundle:categorie_user')->findOneBy(array(
            'id'=>$user->getCategory()
        ));
        return $this->redirectToRoute('searchQuery', array(
            'category' => $categorie_user->getName(),
            'user' => $user->getUsername()
        ));

    }


    /**
     * @Route("/{category}/{user}/index",name="searchQuery",methods={"GET"})
     */
    public function searchQueryAction(Request $request,$user,$category)
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('adminBundle:User')->findOneBy(array(
            'username'=>$user
        ));

        return $this->render('userBundle/index/index.html.twig',array(
            'user' => $users,
            'category' => $category,


        ));

    }


    /**
     * get user name
     *
     * @Route("/getlistcustomer/", name="getlistcustomer",options={"expose"=true},methods={"GET"})
     */
    public function getlistcustomerAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('adminBundle:User')->findAll();
            $all=array();
            $string = "";
            foreach ($user as $cmp) {
                $username = $cmp->getUsername();

                if (!in_array($username, $all)) {

                    $string .= $username;
                    $string .= ",";
                    $string .= $cmp->getCountry();

                    $all[] = $string;
                    $string = "";

                }
            }
            $serializer = $this->get('serializer');
            $array = $serializer->normalize($all);
            return new  JsonResponse($array);

        }else {
            $response = json_encode(array('Error' => 'Please try later'));
            return new Response($response, 200);
        }
    }


    /**
     * get user name
     *
     * @Route("/logoutuser/{user}/{category}", name="logoutuser",options={"expose"=true},methods={"GET"})
     */
    public function logoutAction(Request $request,$user,$category) {
        //do whatever you want here
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('adminBundle:User')->findOneBy(array(
            'username'=>$user
        ));

        //clear the token, cancel session and redirect
        $this->get("security.token_storage")->setToken(null); // Exception thrown here


        return $this->redirectToRoute('searchQuery', array(
            'category' => $category,
            'user' => $user
        ));
    }

}
