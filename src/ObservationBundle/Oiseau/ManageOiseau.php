<?php

namespace ObservationBundle\Oiseau;

use Doctrine\ORM\EntityManager;
use ObservationBundle\Form\ObservationType;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use ObservationBundle\Entity\Observation;

class ManageOiseau
{
    private $em;

    private $router;

    private $formFactory;

    protected $requestStack;

    protected $tokenStorage;

    protected $authorizationChecker;


    public function __construct(EntityManager $em, $formFactory, $router, RequestStack $requestStack, TokenStorage $tokenStorage, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->em = $em;
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->requestStack = $requestStack;
        $this->tokenStorage = $tokenStorage;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function oiseauView($slug)
    {
        $oiseau = $this->em->getRepository('ObservationBundle:Oiseau')->findOneBy(
            array('slug' => $slug));

        $observations = $this->em->getRepository('ObservationBundle:Observation')->findByOiseau($oiseau->getId());

        return [$oiseau, $observations];
    }

    public function oiseauAdd($slug)
    {
        $request = $this->requestStack->getCurrentRequest();
        $user = $this->tokenStorage->getToken()->getUser();
        $oiseau = $this->em->getRepository('ObservationBundle:Oiseau')->findOneBy(
            array('slug' => $slug));

        $observation = new Observation();
        $form   = $this->formFactory->create(ObservationType::class, $observation);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            if ($this->authorizationChecker->isGranted('ROLE_PRO')) {
                $observation->setValidated(1);
            }
            $observation->setUser($user);
            $observation->setOiseau($oiseau);
            $this->em->persist($observation);
            $this->em->flush();
        }

        return [$form, $oiseau];
    }

}