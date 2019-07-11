<?php


namespace UserBundle\Controller;


use adminBundle\Entity\found_itemes;
use adminBundle\Entity\lost_itemes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class lostController extends Controller
{

    /**
     * @Route("/{category}/{user}/lost-item",name="lost-frontend-create")
     */
    public function indexAction(Request $request,$user,$category)
    {

        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('adminBundle:User')->findOneBy(array(
            'username'=>$user
        ));

        $map = $em->getRepository('adminBundle:search_area')->findOneBy(array(
            'customer'=>$users
        ));
        $categortyfilter = $em->getRepository('adminBundle:category_itemes')->findAll();


        $lost_item = new lost_itemes();
        $form = $this->createForm('adminBundle\Form\lost_itemesType', $lost_item)
            ->remove('lostArea')
            ->remove('contactInfo');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lost_item);
            $em->flush();

            return $this->redirectToRoute('found_itemes_show', array('id' => $lost_item->getId()));
        }


        return $this->render('userBundle/lost_itemes/lost.html.twig',array(
            'user' => $users,
            'category' => $category,
            'form' => $form->createView(),
            'map' =>$map,
            'categortyfilter' => $categortyfilter,




        ));
    }


}