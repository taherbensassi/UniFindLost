<?php

namespace adminBundle\Controller;

use adminBundle\Entity\search_area;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Search_area controller.
 *
 * @Route("Customer/Search-area")
 */
class search_areaController extends Controller
{
    /**
     * Lists all search_area entities.
     *
     * @Route("/", name="search_area_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $search_areas = $em->getRepository('adminBundle:search_area')->findAll();

        return $this->render('CustomerBundle/search_area/index.html.twig', array(
            'search_areas' => $search_areas,
        ));
    }

    /**
     * Creates a new search_area entity.
     *
     * @Route("/new", name="search_area_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $search_area = new Search_area();
        $form = $this->createForm('adminBundle\Form\search_areaType', $search_area);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($search_area);
            $em->flush();

            return $this->redirectToRoute('search_area_show', array('id' => $search_area->getId()));
        }

        return $this->render('CustomerBundle/search_area/new.html.twig', array(
            'search_area' => $search_area,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a search_area entity.
     *
     * @Route("/{id}", name="search_area_show")
     * @Method("GET")
     */
    public function showAction(search_area $search_area)
    {
        $deleteForm = $this->createDeleteForm($search_area);

        return $this->render('CustomerBundle/search_area/show.html.twig', array(
            'search_area' => $search_area,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing search_area entity.
     *
     * @Route("/{id}/edit", name="search_area_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, search_area $search_area)
    {
        $deleteForm = $this->createDeleteForm($search_area);
        $editForm = $this->createForm('adminBundle\Form\search_areaType', $search_area);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('search_area_edit', array('id' => $search_area->getId()));
        }

        return $this->render('CustomerBundle/search_area/edit.html.twig', array(
            'search_area' => $search_area,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a search_area entity.
     *
     * @Route("/{id}", name="search_area_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, search_area $search_area)
    {
        $form = $this->createDeleteForm($search_area);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($search_area);
            $em->flush();
        }

        return $this->redirectToRoute('search_area_index');
    }

    /**
     * Creates a form to delete a search_area entity.
     *
     * @param search_area $search_area The search_area entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(search_area $search_area)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('search_area_delete', array('id' => $search_area->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
