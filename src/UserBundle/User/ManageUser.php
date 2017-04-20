<?php

namespace UserBundle\User;

use Doctrine\ORM\EntityManager;
use PlatformBundle\Email\Mailer;
use UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ManageUser
{
    private $em;
    private $formFactory;
    private $router;
    protected $tokenStorage;
    private $mailer;

    public function __construct(EntityManager $em, $formFactory, $router, RequestStack $requestStack, TokenStorage $tokenStorage, Mailer $mailer)
    {
        $this->em = $em;
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->requestStack = $requestStack;
        $this->tokenStorage = $tokenStorage;
        $this->mailer = $mailer;
    }

    /**
     * Liste tous les membres inscrits
     *
     */
    public function userIndex ()
    {

        $users = $this->em->getRepository('UserBundle:User')->findAll();

        return $users;
    }

    /**
     * Reset le password d'un membre
     *
     */
    public function reset()
    {
        $request = $this->requestStack->getCurrentRequest();


        $error = false;


        if ($request->isMethod('POST')) {

            $user = $this->em->getRepository('UserBundle:User')->findOneBy(
                array('email' => $request->request->get('email')));
        }
            try {
                $password = bin2hex(random_bytes(6));
                $user->setPlainPassword($password);
                $this->em->flush();
                $this->mailer->resetPasswordMail($user, $password);
            }
            catch (\Error $e){
                $error = "Cet e-mail ne correspond à aucun compte utilisateur. Veuillez vérifier votre saisie.";
            }


        return $error;

    }

    /**
     * Ajoute un membre
     *
     */
    public function userAdd ()
    {
        $request = $this->requestStack->getCurrentRequest();
        $user = new User();
        $form = $this->formFactory->create('UserBundle\Form\RegistrationType', $user)
            ->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($user);
            $this->em->flush();
        }
        return $form;
    }

    /**
     * Supprime un membre
     *
     */
    public function userDelete ($id)
    {
        $user = $this->em->getRepository('UserBundle:User')->find($id);
        if ($user === null) {
            return $this->router->generate('admin');
        }

        $this->em->remove($user);
        $this->em->flush();

        $response = new RedirectResponse($this->router->generate('admin'));

        return $response->send();
    }

    /**
     * Affiche un formulaire pour modifier un membre
     *
     */
    public function userEdit ($id)
    {
        $request = $this->requestStack->getCurrentRequest();
        $user = $this->em->getRepository('UserBundle:User')->find($id);
        $userBefore = $this->em->getRepository('UserBundle:User')->find($id-1);
        $userNext= $this->em->getRepository('UserBundle:User')->find($id+1);

        $form = $this->formFactory->create('UserBundle\Form\RegistrationType', $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
        }
        return [$user, $userBefore, $userNext, $form];
    }

}