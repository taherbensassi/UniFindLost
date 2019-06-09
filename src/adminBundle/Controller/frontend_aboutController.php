<?php

namespace adminBundle\Controller;

use adminBundle\Entity\frontend_about;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Frontend_about controller.
 *
 * @Route("frontend_about")
 */
class frontend_aboutController extends Controller
{
    /**
     * Lists all frontend_about entities.
     *
     * @Route("/", name="frontend_about_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $frontend_abouts = $em->getRepository('adminBundle:frontend_about')->findAll();

        return $this->render('frontend_about/index.html.twig', array(
            'frontend_abouts' => $frontend_abouts,
        ));
    }

    /**
     * Creates a new frontend_about entity.
     *
     * @Route("/new", name="frontend_about_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $frontend_about = new Frontend_about();
        $form = $this->createForm('adminBundle\Form\frontend_aboutType', $frontend_about);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($frontend_about);
            $em->flush();

            return $this->redirectToRoute('frontend_about_show', array('id' => $frontend_about->getId()));
        }

        return $this->render('frontend_about/new.html.twig', array(
            'frontend_about' => $frontend_about,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a frontend_about entity.
     *
     * @Route("/{id}", name="frontend_about_show")
     * @Method("GET")
     */
    public function showAction(frontend_about $frontend_about)
    {
        $deleteForm = $this->createDeleteForm($frontend_about);

        return $this->render('frontend_about/show.html.twig', array(
            'frontend_about' => $frontend_about,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing frontend_about entity.
     *
     * @Route("/{id}/edit", name="frontend_about_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, frontend_about $frontend_about)
    {
        $deleteForm = $this->createDeleteForm($frontend_about);
        $editForm = $this->createForm('adminBundle\Form\frontend_aboutType', $frontend_about);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('frontend_about_edit', array('id' => $frontend_about->getId()));
        }

        return $this->render('frontend_about/edit.html.twig', array(
            'frontend_about' => $frontend_about,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a frontend_about entity.
     *
     * @Route("/{id}", name="frontend_about_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, frontend_about $frontend_about)
    {
        $form = $this->createDeleteForm($frontend_about);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($frontend_about);
            $em->flush();
        }

        return $this->redirectToRoute('frontend_about_index');
    }

    /**
     * Creates a form to delete a frontend_about entity.
     *
     * @param frontend_about $frontend_about The frontend_about entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(frontend_about $frontend_about)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('frontend_about_delete', array('id' => $frontend_about->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
