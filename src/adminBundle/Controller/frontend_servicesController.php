<?php

namespace adminBundle\Controller;

use adminBundle\Entity\frontend_services;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Frontend_service controller.
 *
 * @Route("frontend_services")
 */
class frontend_servicesController extends Controller
{
    /**
     * Lists all frontend_service entities.
     *
     * @Route("/", name="frontend_services_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $frontend_services = $em->getRepository('adminBundle:frontend_services')->findAll();

        return $this->render('adminBundle/frontend_services/index.html.twig', array(
            'frontend_services' => $frontend_services,
        ));
    }

    /**
     * Creates a new frontend_service entity.
     *
     * @Route("/new", name="frontend_services_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $frontend_service = new frontend_services();
        $form = $this->createForm('adminBundle\Form\frontend_servicesType', $frontend_service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($frontend_service);
            $em->flush();

            $this->get('session')->getFlashBag()->set('success', 'Created with sccess');
            return $this->redirectToRoute('frontend_services_index');        }

        return $this->render('adminBundle/frontend_services/new.html.twig', array(
            'frontend_service' => $frontend_service,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a frontend_service entity.
     *
     * @Route("/{id}", name="frontend_services_show")
     * @Method("GET")
     */
    public function showAction(frontend_services $frontend_service)
    {
        $deleteForm = $this->createDeleteForm($frontend_service);

        return $this->render('adminBundle/frontend_services/show.html.twig', array(
            'frontend_service' => $frontend_service,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing frontend_service entity.
     *
     * @Route("/{id}/edit", name="frontend_services_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, frontend_services $frontend_service)
    {
        $deleteForm = $this->createDeleteForm($frontend_service);
        $editForm = $this->createForm('adminBundle\Form\frontend_servicesType', $frontend_service);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->get('session')->getFlashBag()->set('success', 'Created with sccess');
            return $this->redirectToRoute('frontend_services_index');
        }

        return $this->render('adminBundle/frontend_services/edit.html.twig', array(
            'frontend_service' => $frontend_service,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a frontend_service entity.
     *
     * @Route("/{id}", name="frontend_services_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, frontend_services $frontend_service)
    {
        $form = $this->createDeleteForm($frontend_service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($frontend_service);
            $em->flush();
        }

        return $this->redirectToRoute('frontend_services_index');
    }

    /**
     * Creates a form to delete a frontend_service entity.
     *
     * @param frontend_services $frontend_service The frontend_service entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(frontend_services $frontend_service)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('frontend_services_delete', array('id' => $frontend_service->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    //delet about section method
    /**
     *
     * @Route("/delete_services_about_us/{id}", name="delete_section_services",options={"expose"=true})
     * @Method({"DELETE"})
     */
    public function delete_services_about_usAction($id,Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $delet = $em->getRepository('adminBundle:frontend_services')->find($id);
            $id= $delet->getId();
            $em->remove($delet);
            $em->flush();
            $response = json_encode(array('Id' => $id,'status'=>'Has been deleted'));
            return new Response($response, 200);
        }else{
            $response = json_encode(array('status' => 'error'));
            return new Response($response, 404);
        }
    }
}
