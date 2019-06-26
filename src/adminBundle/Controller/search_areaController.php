<?php

namespace adminBundle\Controller;

use adminBundle\Entity\search_area;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Search_area controller.
 *
 * @Route("Customer/Search")
 */
class search_areaController extends Controller
{



    /**
     * Lists all search_area entities.
     *
     * @Route("/sendData_searcharea_map-search", name="sendData",options={"expose"=true})
     * @Method({"GET", "POST"})
     */
    public function ValidateUserAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {

            $data = $request->get('html');
            $id = $request->get('search_area');

            $em = $this->getDoctrine()->getManager();
            $cutsomer_search = $em->getRepository('adminBundle:search_area')->find($id);
            $cutsomer_search->setHtml($data);
            $cutsomer_search->setDesciption($data);
            $em->persist($cutsomer_search);
            $em->flush();



            $response = json_encode("Success");
            return new Response($response, 200);


        } else {
            $response = json_encode("error");
            return new Response($response, 400);


        }
    }

    /**
     * Lists all search_area entities.
     *
     * @Route("/redirect-search", name="redirect_search")
     * @Method("GET")
     */
    public function redirect_search_areAction()
    {

        $em = $this->getDoctrine()->getManager();
        $customer = $this->get('security.token_storage')->getToken()->getUser();
        $cutsomer_search = $em->getRepository('adminBundle:User')->find($customer);
        $search_areas = $em->getRepository('adminBundle:search_area')->findOneBy(array(
            'customer'=>$cutsomer_search
        ));

        if($search_areas==null){
            return $this->redirectToRoute('search_area_first_time');

        }else{
            return $this->redirectToRoute('search_area_new', array('id' => $search_areas->getId()));

        }


    }


    /**
     * Creates a new search_area entity firsttimer
     *
     * @Route("/search-area-upload", name="search_area_first_time")
     * @Method({"GET", "POST"})
     */
    public function search_area_first_timerAction(Request $request)
    {
        $search_area = new Search_area();
        $form = $this->createForm('adminBundle\Form\search_areaType', $search_area)
                    ->remove('desciption')
                    ->remove('html')
                    ->remove('createdAt');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $customer = $this->get('security.token_storage')->getToken()->getUser();
            $cutsomer_search = $em->getRepository('adminBundle:User')->find($customer);
            $file = $search_area->getUrl();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('plan_directory'),
                $fileName
            );
            $search_area->setUrl($fileName);
            $search_area->setCustomer($cutsomer_search);
            $search_area->setCreatedAt(new \DateTime('now'));

            $em->persist($search_area);
            $em->flush();

            return $this->redirectToRoute('search_area_new', array('id' => $search_area->getId()));



        }

        return $this->render('CustomerBundle/search_area/first_time_set_plan.html.twig', array(
            'search_area' => $search_area,
            'form' => $form->createView(),
        ));
    }


    /**
     * Creates a new search_area entity.
     *
     * @Route("/new/{id}", name="search_area_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request,$id)
    {
        $search_area = new Search_area();
        $form = $this->createForm('adminBundle\Form\search_areaType', $search_area);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        $picture = $em->getRepository('adminBundle:search_area')->find($id);


        return $this->render('CustomerBundle/search_area/new.html.twig', array(
            'search_area' => $search_area,
            'form' => $form->createView(),
            'id' => $id,
            'picture' => $picture,
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
