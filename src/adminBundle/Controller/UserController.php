<?php

namespace adminBundle\Controller;

use adminBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * User controller.
 *
 * @Route("administration/user")
 */
class UserController extends Controller
{
    /**
     * Lists all user entities.
     *
     * @Route("/", name="user_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $sf_Users = $em->getRepository('adminBundle:User')->findAll();

        return $this->render('adminBundle/user/index.html.twig', array(
            'active'=>'users',
            'users'=>$sf_Users,

        ));
    }




    /**
     * Finds and displays a user entity.
     *
     * @Route("/{id}", name="user_show")
     * @Method("GET")
     */
    public function showAction(User $user)
    {
        $deleteForm = $this->createDeleteForm($user);

        return $this->render('user/show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/edit/{id}", name="user_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, User $user)
    {
        $logo=$user->getPicture();
        $editForm = $this->createForm('adminBundle\Form\RegistrationType', $user)
                         ->remove('plainPassword')
                         ->remove('firstname')
                         ->remove('lastname');
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {




            //picture edit
            $file = $user->getPicture();
            if($file != null)
            {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $this->getParameter('logo_directory'),
                    $fileName
                );
                $user->setPicture($fileName);
            }else{
                $user->setPicture($logo);
            }


            //enabled
            $enabled = $request->get('optionsRadios');
            if($enabled=="Enabled"){
                $user->setEnabled(1);
            }else{
                $user->setEnabled(0);
            }






            //location sets
            $user->setCountry($request->get('country')) ;
            $user->setZip($request->get('postal_code')) ;
            $user->setAdresse($request->get('formatted_address')) ;
            $user->setstate($request->get('administrative_area_level_1')) ;





            //role configuration
            $role = $request->get('role');
            if($role=="ROLE_ADMIN") {
                $roles = array('ROLE_ADMIN');
                $user->setRoles($roles);
            }elseif($role==="ROLE_CUSTOMER") {
                $roles = array('ROLE_CUSTOMER');
                $user->setRoles($roles);
            }


            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('user_index');

        }

        return $this->render('adminBundle/user/edit.html.twig', array(
            'user' => $user,
            'form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a user entity.
     *
     * @Route("/{id}", name="user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * Creates a form to delete a user entity.
     *
     * @param User $user The user entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }



    //update user status
    /**
     *
     *
     * @Route("/updateuserstatus/", name="updateuserstatus",options={"expose"=true})
     * @Method({"GET", "POST"})
     */
    public function updateuserstatusAction(Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $pk = $request->get("pk");
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('adminBundle:User')->find($pk);
            if($user->isEnabled()==1){
                $user->setEnabled(0);
                $em->persist($user);
                $em->flush();
            }else{
                $user->setEnabled(1);
                $em->persist($user);
                $em->flush();
            }
            $response = json_encode(array('User' => $user->getUsername(),'status'=>'Has been updated'));
            return new Response($response, 200);
        }else{
            $response = json_encode(array('status' => 'error'));
            return new Response($response, 404);
        }
    }


    //delet user method
    /**
     *
     * @Route("/delete_user_admin/{id}", name="delete_user_admin",options={"expose"=true})
     * @Method({"DELETE"})
     */
    public function delAction($id,Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $delet = $em->getRepository('adminBundle:User')->find($id);
            $username= $delet->getUsername();
            $em->remove($delet);
            $em->flush();
            $response = json_encode(array('User' => $username,'status'=>'Has been deleted'));
            return new Response($response, 200);
        }else{
            $response = json_encode(array('status' => 'error'));
            return new Response($response, 404);
        }
    }


    /**
     *
     * @Route("/DeletlogouserbyId/{id}", name="DeletlogouserbyId",options={"expose"=true})
     * @Method({"DELETE"})
     */
    public function delimageAction($id,Request $request)
    {
        if($request->isXmlHttpRequest()) {

            $em = $this->getDoctrine()->getManager();
            $delet = $em->getRepository('adminBundle:User')->find($id);
            $path = $this->get('kernel')->getRootDir() . '/../web/uploads/logoUser/';
            unlink($path."".($delet->getPicture()));
            $delet->setPicture(null);
            $em->flush();
            $response = json_encode(array('msg' => 'succ'));
            return new Response($response, 200);
        }
    }
}
