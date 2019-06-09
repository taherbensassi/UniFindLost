<?php

namespace UserBundle\Controller;

use adminBundle\Entity\categorie_user;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class RegisteruserController extends Controller
{


    /**
     * @Route("/userRegisteration/{category}/{userId}",name="userRegisteration")
     */
    public function userRegisterationAction(Request $request,$category,$userId)
    {
        $em = $this->getDoctrine()->getManager();



        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');



        $user = $userManager->createUser();
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {


                $event = new FormEvent($form, $request);


                $roles = array('ROLE_USER');
                $user->setRoles($roles);


                //created-at
                $user->setCreatedAt(new \DateTime('now'));


                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

                $userManager->updateUser($user);


                if (null === $response = $event->getResponse()) {
                    $url = $this->generateUrl('searchQuery', array(
                        'category' =>$category ,
                        'user' => $userId
                    ));
                    $response = new RedirectResponse($url);
                    $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                }

                //$dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                return $response;



        }


        return $this->render('userBundle/BaseTemplate/register_modal.html.twig', array(
            'form' => $form->createView(),
            'category' => $category,
            'user' => $userId,
        ));
    }





    /**
     * Add User entity.
     *
     * @Route("/validatUser", name="validatUser",options={"expose"=true})
     * @Method({"GET", "POST"})
     */
    public function ValidateUserAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $username = $request->get('username');
            $email = $request->get('email');
            $firstpassword = $request->get('firstpassword');
            $secondpasswrd = $request->get('secondpasswrd');


            $user_email = $em->getRepository('adminBundle:User')->findOneBy(array('email' => $email));
            $user_username = $em->getRepository('adminBundle:User')->findOneBy(array('username' => $username));




            if($username == "")
            {
                $response = json_encode("Username* Required");
                return new Response($response, 400);
            }
            elseif($email == "")
            {
                $response = json_encode("email* Required");
                return new Response($response, 400);
            }
            elseif($firstpassword == "")
            {
                $response = json_encode("password* Required");
                return new Response($response, 400);
            }
            elseif($secondpasswrd == "")
            {
                $response = json_encode("Re-password* Required");
                return new Response($response, 400);
            }
            elseif($user_email)
            {
                $response = json_encode("E-mail already exisit ");
                return new Response($response, 400);
            }
            elseif($firstpassword != $secondpasswrd)
            {
                $response = json_encode("Password mismatch");
                return new Response($response, 400);
            }
            elseif($user_username)
            {
                $response = json_encode("Username aleady Exist");
                return new Response($response, 500);
            } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                $response = json_encode("Please insert a valid Email");
                return new Response($response, 400);
            }

            else
            {
                $response = json_encode("Success");
                return new Response($response, 200);
            }

        } else {
            $response = json_encode("error");
            return new Response($response, 400);


        }
    }



}
