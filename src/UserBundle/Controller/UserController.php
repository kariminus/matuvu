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
        $manageUser = $this->get('manage_user');
        $users = $manageUser->userIndex();
        return $this->render('UserBundle::index.html.twig', array(
            'users' => $users,
        ));
    }
    public function editAction(User $user)
    {
        $manageUser = $this->get('manage_user');
        $array = $manageUser->userEdit($user);
        return $this->render('UserBundle::edit.html.twig', array(
            'user' => $array[0],
            'form' => $array[1]->createView(),
        ));
    }
    public function deleteAction($id)
    {
        $manageUser = $this->get('manage_user');
        $manageUser->userDelete($id);
        return $this->redirectToRoute('admin_user_index');
    }
}