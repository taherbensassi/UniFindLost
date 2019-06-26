<?php
// src/AppBundle/Controller/RegistrationController.php

namespace adminBundle\Controller;

use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use FOS\UserBundle\Event\GetResponseUserEvent;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends BaseController
{

    public function __construct()
    {
    }

    public function registerAction(Request $request)
    {

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

            if ($form->isValid()) {
                $event = new FormEvent($form, $request);

                //logo
                $file = $user->getpicture();
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move(
                    $this->getParameter('logo_directory'),
                    $fileName
                );
                $user->setpicture($fileName);

                //enabled
                $enabled = $request->get('optionsRadios');
                if($enabled=="Enabled"){
                    $user->setEnabled(1);
                }else{
                    $user->setEnabled(0);
                }


                //location sets
                $user->setCountry($request->get('country')) ;
                $user->setZip($request->get('postal_code')) ;
                $user->setAdresse($request->get('formatted_address')) ;
                $user->setstate($request->get('administrative_area_level_1')) ;

                //role configuration
                $role = $request->get('role');
                if($role=="admin") {
                    $roles = array('ROLE_ADMIN');
                    $user->setRoles($roles);
                }elseif($role==="customer") {
                    $roles = array('ROLE_CUSTOMER');
                    $user->setRoles($roles);
                }

                $user->setLatitude($request->get('lat')) ;
                $user->setLongitude($request->get('lng')) ;


                //created-at
                $user->setCreatedAt(new \DateTime('now'));


                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

                $userManager->updateUser($user);

                /*****************************************************
                 * Add new functionality (e.g. log the registration) *
                 *****************************************************/
                //$this->container->get('logger')->info(
                  //  sprintf("New user registration: %s", $user)
                //);

                if (null === $response = $event->getResponse()) {
                    $url = $this->generateUrl('user_index');
                    $response = new RedirectResponse($url);
                }

                    //$dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                return $response;
            }

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_FAILURE, $event);

            if (null !== $response = $event->getResponse()) {
                return $response;
            }
        }

        return $this->render('adminBundle/user/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }




}
