<?php

namespace UserBundle\User;

use Doctrine\ORM\EntityManager;
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

    public function __construct(EntityManager $em, $formFactory, $router, RequestStack $requestStack, TokenStorage $tokenStorage)
    {
        $this->em = $em;
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->requestStack = $requestStack;
        $this->tokenStorage = $tokenStorage;
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
        $observations = $user->getObservations();
        foreach ($observations as $observation)
        {
            $this->em->remove($observation);
            $this->em->flush();
        }
        $this->em->remove($user);
        $this->em->flush();

        $response = new RedirectResponse($this->router->generate('admin'));

        $response->send();
    }

    /**
     * Affiche un formulaire pour modifier un membre
     *
     */
    public function userEdit ($id)
    {
        $request = $this->requestStack->getCurrentRequest();
        $user = $this->em->getRepository('UserBundle:User')->find($id);
        $form = $this->formFactory->create('UserBundle\Form\RegistrationType', $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
        }
        return [$user, $form];
    }

}