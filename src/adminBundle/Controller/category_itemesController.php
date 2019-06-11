<?php

namespace adminBundle\Controller;

use adminBundle\Entity\category_itemes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

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

        return $this->render('category_itemes/index.html.twig', array(
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
        $category_iteme = new Category_iteme();
        $form = $this->createForm('adminBundle\Form\category_itemesType', $category_iteme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category_iteme);
            $em->flush();

            return $this->redirectToRoute('category_itemes_show', array('id' => $category_iteme->getId()));
        }

        return $this->render('category_itemes/new.html.twig', array(
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

        return $this->render('category_itemes/show.html.twig', array(
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

            return $this->redirectToRoute('category_itemes_edit', array('id' => $category_iteme->getId()));
        }

        return $this->render('category_itemes/edit.html.twig', array(
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
}
