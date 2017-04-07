<?php

namespace PlatformBundle\Platform;

use UserBundle\Entity\User;
use ObservationBundle\Entity\Observation;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class ManagePlatform
{
    private $em;

    private $router;

    protected $requestStack;

    private $formFactory;

    protected $tokenStorage;

    protected $authorizationChecker;

    public function __construct(EntityManager $em, $router, RequestStack $requestStack, $formFactory, TokenStorage $tokenStorage, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->em = $em;
        $this->router = $router;
        $this->requestStack = $requestStack;
        $this->formFactory = $formFactory;
        $this->tokenStorage = $tokenStorage;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function platformProfil()
    {
        $user = $this->tokenStorage->getToken()->getUser();

        if ($this->authorizationChecker->isGranted('ROLE_PRO'))
        {
            $observations = $this->em->getRepository('ObservationBundle:Observation')->getAllToValidate();
        }
        else {
            $observations = $this->em->getRepository('ObservationBundle:Observation')->getAllNotValidated($user->getId());
        }


        return [$user, $observations];
    }

    public function platformObservations()
    {
        $user = $this->tokenStorage->getToken()->getUser();

        $observations = $this->em->getRepository('ObservationBundle:Observation')->getAllValidated($user->getId());

        return [$user, $observations];
    }

    public function profilEdit()
    {
        $request = $this->requestStack->getCurrentRequest();
        $user = $this->tokenStorage->getToken()->getUser();

        $form = $this->formFactory->create('UserBundle\Form\UserEditType', $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
        }
        return [$user, $form];
    }

    public function adminIndex()
    {
        $user =  $this->tokenStorage->getToken()->getUser();

        $observations = $this->em->getRepository('ObservationBundle:Observation')->findAll();

        return [$user, $observations];
    }

}