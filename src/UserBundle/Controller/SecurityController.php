<?php


namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UserBundle\Form\LoginForm;

class SecurityController extends Controller
{
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        $form = $this->createForm(LoginForm::class, [
            '_username' => $lastUsername,
        ]);
        return $this->render(
            'UserBundle::login.html.twig',
            array(
                'form' => $form->createView(),
                'error' => $error,
            )
        );
    }
    public function logoutAction()
    {
        throw new \Exception('this should not be reached!');
    }
}