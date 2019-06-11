<?php

namespace adminBundle\Controller;

use adminBundle\Entity\information_customer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Information_customer controller.
 *
 * @Route("information_customer")
 */
class information_customerController extends Controller
{
    /**
     * Lists all information_customer entities.
     *
     * @Route("/", name="information_customer_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $information_customers = $em->getRepository('adminBundle:information_customer')->findAll();

        return $this->render('information_customer/index.html.twig', array(
            'information_customers' => $information_customers,
        ));
    }

    /**
     * Creates a new information_customer entity.
     *
     * @Route("/new", name="information_customer_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $information_customer = new Information_customer();
        $form = $this->createForm('adminBundle\Form\information_customerType', $information_customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($information_customer);
            $em->flush();

            return $this->redirectToRoute('information_customer_show', array('id' => $information_customer->getId()));
        }

        return $this->render('information_customer/new.html.twig', array(
            'information_customer' => $information_customer,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a information_customer entity.
     *
     * @Route("/{id}", name="information_customer_show")
     * @Method("GET")
     */
    public function showAction(information_customer $information_customer)
    {
        $deleteForm = $this->createDeleteForm($information_customer);

        return $this->render('information_customer/show.html.twig', array(
            'information_customer' => $information_customer,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing information_customer entity.
     *
     * @Route("/{id}/edit", name="information_customer_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, information_customer $information_customer)
    {
        $deleteForm = $this->createDeleteForm($information_customer);
        $editForm = $this->createForm('adminBundle\Form\information_customerType', $information_customer);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('information_customer_edit', array('id' => $information_customer->getId()));
        }

        return $this->render('information_customer/edit.html.twig', array(
            'information_customer' => $information_customer,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a information_customer entity.
     *
     * @Route("/{id}", name="information_customer_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, information_customer $information_customer)
    {
        $form = $this->createDeleteForm($information_customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($information_customer);
            $em->flush();
        }

        return $this->redirectToRoute('information_customer_index');
    }

    /**
     * Creates a form to delete a information_customer entity.
     *
     * @param information_customer $information_customer The information_customer entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(information_customer $information_customer)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('information_customer_delete', array('id' => $information_customer->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
