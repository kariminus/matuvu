<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Form\UserRegistrationForm;

/**
 * User controller.
 *
 */
class UserController extends Controller
{
    /**
     * Inscription d'un membre
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
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

    /**
     * Liste tous les membres inscrits
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('UserBundle::users.html.twig', array(
            'users' => $users = $this->get('manage_user')->userIndex(),
        ));
    }

    /**
     * Ajoute un membre
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction()
    {
        $form = $this->get('manage_user')->userAdd();
        return $this->render('UserBundle::new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Affiche un formulaire pour modifier un membre
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction($id)
    {
        $array = $this->get('manage_user')->userEdit($id);
        return $this->render('UserBundle::edit.html.twig', array(
            'user' => $array[0],
            'form' => $array[1]->createView()
        ));
    }

    /**
     * Supprime un membre
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($id)
    {
        $this->get('manage_user')->userDelete($id);

        return $this->redirectToRoute('admin');
    }
}