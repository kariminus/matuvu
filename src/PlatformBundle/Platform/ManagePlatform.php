<?php

namespace PlatformBundle\Platform;

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

    /**
     * Affiche une liste d'observations suivant le rôle de l'utilisateur
     * @return $observations
     */
    public function platformProfil()
    {
        $user = $this->tokenStorage->getToken()->getUser();

        if ($this->authorizationChecker->isGranted('ROLE_PRO'))
        {
            $observations = $this->em->getRepository('ObservationBundle:Observation')->findBy(array(
                'validated' => 0
            ));
        }
        else {
            $observations = $this->em->getRepository('ObservationBundle:Observation')->findBy(array(
                'user' => $user->getId(),
                'validated' => 0
            ));
        }


        return $observations;
    }

    /**
     * Affiche les observations d'un membre
     * @return array
     */
    public function platformObservations()
    {
        $user = $this->tokenStorage->getToken()->getUser();

        $observations = $this->em->getRepository('ObservationBundle:Observation')->findBy(array(
            'validated' => 1,
            'user' => $user->getId()
        ));

        return [$user, $observations];
    }

    /**
     * Formulaire d'édition du profil d'un membre
     * @return array
     */
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