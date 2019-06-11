<?php

namespace adminBundle\Controller;

use adminBundle\Entity\found_itemes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Found_iteme controller.
 *
 * @Route("found_itemes")
 */
class found_itemesController extends Controller
{
    /**
     * Lists all found_iteme entities.
     *
     * @Route("/", name="found_itemes_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $found_itemes = $em->getRepository('adminBundle:found_itemes')->findAll();

        return $this->render('found_itemes/index.html.twig', array(
            'found_itemes' => $found_itemes,
        ));
    }

    /**
     * Creates a new found_iteme entity.
     *
     * @Route("/new", name="found_itemes_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $found_iteme = new Found_iteme();
        $form = $this->createForm('adminBundle\Form\found_itemesType', $found_iteme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($found_iteme);
            $em->flush();

            return $this->redirectToRoute('found_itemes_show', array('id' => $found_iteme->getId()));
        }

        return $this->render('found_itemes/new.html.twig', array(
            'found_iteme' => $found_iteme,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a found_iteme entity.
     *
     * @Route("/{id}", name="found_itemes_show")
     * @Method("GET")
     */
    public function showAction(found_itemes $found_iteme)
    {
        $deleteForm = $this->createDeleteForm($found_iteme);

        return $this->render('found_itemes/show.html.twig', array(
            'found_iteme' => $found_iteme,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing found_iteme entity.
     *
     * @Route("/{id}/edit", name="found_itemes_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, found_itemes $found_iteme)
    {
        $deleteForm = $this->createDeleteForm($found_iteme);
        $editForm = $this->createForm('adminBundle\Form\found_itemesType', $found_iteme);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('found_itemes_edit', array('id' => $found_iteme->getId()));
        }

        return $this->render('found_itemes/edit.html.twig', array(
            'found_iteme' => $found_iteme,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a found_iteme entity.
     *
     * @Route("/{id}", name="found_itemes_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, found_itemes $found_iteme)
    {
        $form = $this->createDeleteForm($found_iteme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($found_iteme);
            $em->flush();
        }

        return $this->redirectToRoute('found_itemes_index');
    }

    /**
     * Creates a form to delete a found_iteme entity.
     *
     * @param found_itemes $found_iteme The found_iteme entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(found_itemes $found_iteme)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('found_itemes_delete', array('id' => $found_iteme->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
