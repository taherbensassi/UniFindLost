<?php

namespace UserBundle\Controller;

use adminBundle\Entity\found_itemes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class foundController extends Controller
{


    /**
     * @Route("/{category}/{user}/found-item",name="found-frontend-create")
     */
    public function indexAction(Request $request,$user,$category)
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('adminBundle:User')->findOneBy(array(
            'username'=>$user
        ));

        $map = $em->getRepository('adminBundle:search_area')->findOneBy(array(
            'customer'=>$users
        ));

        $found_iteme = new found_itemes();
        $form = $this->createForm('adminBundle\Form\found_itemesType', $found_iteme)
                    ->remove('foundArea')
                    ->remove('contactInfo');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($found_iteme);
            $em->flush();

            return $this->redirectToRoute('found_itemes_show', array('id' => $found_iteme->getId()));
        }


        return $this->render('userBundle/found_itemes/found.html.twig',array(
            'user' => $users,
            'category' => $category,
            'form' => $form->createView(),
            'map' =>$map,



        ));
    }



}
