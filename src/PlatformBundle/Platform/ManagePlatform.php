<?php

namespace PlatformBundle\Platform;

use UserBundle\Entity\User;
use ObservationBundle\Entity\Observation;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class ManagePlatform
{
    private $em;

    private $router;

    protected $requestStack;

    private $formFactory;

    protected $tokenStorage;

    public function __construct(EntityManager $em, $router, RequestStack $requestStack, $formFactory, TokenStorage $tokenStorage)
    {
        $this->em = $em;
        $this->router = $router;
        $this->requestStack = $requestStack;
        $this->formFactory = $formFactory;
        $this->tokenStorage = $tokenStorage;
    }

    public function platformProfil()
    {
        return $this->tokenStorage->getToken()->getUser();
    }

    public function platformObservations()
    {
        $user = $this->tokenStorage->getToken()->getUser();

        $observations = $this->em->getRepository('ObservationBundle:Observation')->findByUser($user->getId());

        return [$user, $observations];
    }

    public function observationView($id)
    {
        $user = $this->tokenStorage->getToken()->getUser();

        $observation = $this->em->getRepository('ObservationBundle:Observation')->findOneById($id);
        $oiseau = $observation->getOiseau();

        return [$user, $observation, $oiseau];
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

}