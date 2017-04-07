<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;
use UserBundle\Form\UserRegistrationForm;

/**
 * User controller.
 *
 */
class UserController extends Controller
{
    public function registerAction(Request $request)
    {
        $form = $this->createForm(UserRegistrationForm::class);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $user = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->get('security.authentication.guard_handler')
                ->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $this->get('app.security.login_form_authenticator'),
                    'main'
                );
        }
        return $this->render('UserBundle::register.html.twig', [
            'form' => $form->createView()
        ]);
    }
    public function indexAction()
    {

        $users = $this->get('manage_user')->userIndex();

        return $this->render('UserBundle::users.html.twig', array(
            'user' => $users[0],
            'users' => $users[1],
        ));
    }

    public function addAction()
    {
        $array = $this->get('manage_user')->userAdd();
        return $this->render('UserBundle::new.html.twig', array(
            'user'=> $array[0],
            'form' => $array[1]->createView(),
        ));
    }
    public function editAction($id)
    {
        $array = $this->get('manage_user')->userEdit($id);
        return $this->render('UserBundle::edit.html.twig', array(
            'user' => $array[0],
            'member' => $array[1],
            'form' => $array[2]->createView()
        ));
    }
    public function deleteAction($id)
    {
        $this->get('manage_user')->userDelete($id);

        return $this->redirectToRoute('admin');
    }
}