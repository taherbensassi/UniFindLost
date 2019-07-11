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
            $userConnect = $this->get('security.token_storage')->getToken()->getUser();


            $photo = $form['photo']->getData();
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($photo) {
                $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photo->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $photo->move(
                        $this->getParameter('found_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $found_iteme->setPhoto($newFilename);
            }

            $foundArea = $request->get('foundmap');
            $found_iteme->setFoundArea($foundArea);
            $found_iteme->setUser($userConnect);






            $em->persist($found_iteme);
            $em->flush();
            $this->get('session')->getFlashBag()->set('success', 'added with sccess');
            return $this->redirectToRoute('Profile_user_connect', array('category' =>$category,'userId'=>$users));
        }


        return $this->render('userBundle/found_itemes/found.html.twig',array(
            'user' => $users,
            'category' => $category,
            'form' => $form->createView(),
            'map' =>$map,



        ));
    }







}
