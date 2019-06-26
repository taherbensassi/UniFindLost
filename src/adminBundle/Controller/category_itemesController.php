<?php

namespace adminBundle\Controller;

use adminBundle\Entity\category_itemes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Category_iteme controller.
 *
 * @Route("category_itemes")
 */
class category_itemesController extends Controller
{
    /**
     * Lists all category_iteme entities.
     *
     * @Route("/", name="category_itemes_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $category_itemes = $em->getRepository('adminBundle:category_itemes')->findAll();

        return $this->render('adminBundle/category_itemes/index.html.twig', array(
            'category_itemes' => $category_itemes,
        ));
    }

    /**
     * Creates a new category_iteme entity.
     *
     * @Route("/new", name="category_itemes_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $category_iteme = new category_itemes();
        $form = $this->createForm('adminBundle\Form\category_itemesType', $category_iteme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $category_iteme->setCreatedAt(new \DateTime('now'));

            $em->persist($category_iteme);
            $em->flush();

            $this->get('session')->getFlashBag()->set('success', 'Created with sccess');
            return $this->redirectToRoute('category_itemes_index');
        }

        return $this->render('adminBundle/category_itemes/new.html.twig', array(
            'category_iteme' => $category_iteme,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a category_iteme entity.
     *
     * @Route("/{id}", name="category_itemes_show")
     * @Method("GET")
     */
    public function showAction(category_itemes $category_iteme)
    {
        $deleteForm = $this->createDeleteForm($category_iteme);

        return $this->render('adminBundle/category_itemes/show.html.twig', array(
            'category_iteme' => $category_iteme,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing category_iteme entity.
     *
     * @Route("/{id}/edit", name="category_itemes_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, category_itemes $category_iteme)
    {
        $deleteForm = $this->createDeleteForm($category_iteme);
        $editForm = $this->createForm('adminBundle\Form\category_itemesType', $category_iteme);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->get('session')->getFlashBag()->set('success', 'Update with sccess');
            return $this->redirectToRoute('category_itemes_index');
        }

        return $this->render('adminBundle/category_itemes/edit.html.twig', array(
            'category_iteme' => $category_iteme,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a category_iteme entity.
     *
     * @Route("/{id}", name="category_itemes_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, category_itemes $category_iteme)
    {
        $form = $this->createDeleteForm($category_iteme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($category_iteme);
            $em->flush();
        }

        return $this->redirectToRoute('category_itemes_index');
    }

    /**
     * Creates a form to delete a category_iteme entity.
     *
     * @param category_itemes $category_iteme The category_iteme entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(category_itemes $category_iteme)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('category_itemes_delete', array('id' => $category_iteme->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    //delet category method
    /**
     *
     * @Route("/delete_category_item/{id}", name="delete_category_item",options={"expose"=true})
     * @Method({"DELETE"})
     */
    public function delAction($id,Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $delet = $em->getRepository('adminBundle:category_itemes')->find($id);
            $name= $delet->getHeading();
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
