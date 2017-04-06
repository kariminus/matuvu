<?php

namespace UserBundle\User;

use Doctrine\ORM\EntityManager;
use UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

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
     * Lists all user entities.
     *
     */
    public function userIndex ()
    {
        $user = $this->tokenStorage->getToken()->getUser();

        $users = $this->em->getRepository('UserBundle:User')->findAll();

        return [$user, $users];
    }

    /**
     * Add a user entity.
     *
     */
    public function userAdd ()
    {
        $request = $this->requestStack->getCurrentRequest();
        $user = $this->tokenStorage->getToken()->getUser();
        $member = new User();
        $form = $this->formFactory->create('UserBundle\Form\RegistrationType', $member)
            ->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($member);
            $this->em->flush();
        }
        return [$user, $form];
    }

    /**
     * Deletes a user entity.
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

        return $this->router->generate('admin');
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     */
    public function userEdit ($id)
    {
        $request = $this->requestStack->getCurrentRequest();
        $user = $this->tokenStorage->getToken()->getUser();
        $member = $this->em->getRepository('UserBundle:User')->find($id);
        $form = $this->formFactory->create('UserBundle\Form\RegistrationType', $member);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
        }
        return [$user, $member, $form];
    }

}