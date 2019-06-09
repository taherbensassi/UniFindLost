<?php

namespace adminBundle\Controller;

use adminBundle\Entity\categorie_user;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Categorie_user controller.
 *
 * @Route("administration/category")
 */
class categorie_userController extends Controller
{
    /**
     * Lists all categorie_user entities.
     *
     * @Route("/", name="categorie_user_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categorie_users = $em->getRepository('adminBundle:categorie_user')->findAll();

        return $this->render('adminBundle/categorie_user/index.html.twig', array(
            'categorie_users' => $categorie_users,
        ));
    }

    /**
     * Creates a new categorie_user entity.
     *
     * @Route("/new", name="categorie_user_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $categorie_user = new Categorie_user();
        $form = $this->createForm('adminBundle\Form\categorie_userType', $categorie_user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $categorie_user->setCreatedAt(new \DateTime('now'));

            $em->persist($categorie_user);
            $em->flush();
            $this->get('session')->getFlashBag()->set('success', 'Created with sccess');
            return $this->redirectToRoute('categorie_user_index');
        }

        return $this->render('adminBundle/categorie_user/new.html.twig', array(
            'categorie_user' => $categorie_user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a categorie_user entity.
     *
     * @Route("/{id}", name="categorie_user_show")
     * @Method("GET")
     */
    public function showAction(categorie_user $categorie_user)
    {
        $deleteForm = $this->createDeleteForm($categorie_user);

        return $this->render('adminBundle/categorie_user/show.html.twig', array(
            'categorie_user' => $categorie_user,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing categorie_user entity.
     *
     * @Route("/{id}/edit", name="categorie_user_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, categorie_user $categorie_user)
    {
        $deleteForm = $this->createDeleteForm($categorie_user);
        $editForm = $this->createForm('adminBundle\Form\categorie_userType', $categorie_user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->get('session')->getFlashBag()->set('success', 'Update with sccess');
            return $this->redirectToRoute('categorie_user_index');
        }

        return $this->render('adminBundle/categorie_user/edit.html.twig', array(
            'categorie_user' => $categorie_user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a categorie_user entity.
     *
     * @Route("/{id}", name="categorie_user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, categorie_user $categorie_user)
    {
        $form = $this->createDeleteForm($categorie_user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($categorie_user);
            $em->flush();
        }

        return $this->redirectToRoute('categorie_user_index');
    }

    /**
     * Creates a form to delete a categorie_user entity.
     *
     * @param categorie_user $categorie_user The categorie_user entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(categorie_user $categorie_user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('categorie_user_delete', array('id' => $categorie_user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }



    //delet category method
    /**
     *
     * @Route("/delete_category_user/{id}", name="delete_category_user",options={"expose"=true})
     * @Method({"DELETE"})
     */
    public function delAction($id,Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $delet = $em->getRepository('adminBundle:categorie_user')->find($id);
            $name= $delet->getName();
            $em->remove($delet);
            $em->flush();
            $response = json_encode(array('Category' => $name,'status'=>'Has been deleted'));
            return new Response($response, 200);
        }else{
            $response = json_encode(array('status' => 'error'));
            return new Response($response, 404);
        }
    }
}
