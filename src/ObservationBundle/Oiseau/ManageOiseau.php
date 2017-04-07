<?php

namespace ObservationBundle\Oiseau;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class ManageOiseau
{
    private $em;

    private $router;

    private $formFactory;

    protected $requestStack;

    protected $tokenStorage;

    protected $authorizationChecker;


    public function __construct(EntityManager $em, $formFactory, $router, RequestStack $requestStack, TokenStorage $tokenStorage)
    {
        $this->em = $em;
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->requestStack = $requestStack;
        $this->tokenStorage = $tokenStorage;
    }

    public function oiseauView($slug)
    {
        $oiseau = $this->em->getRepository('ObservationBundle:Oiseau')->findOneBy(
            array('slug' => $slug));

        $observations = $this->em->getRepository('ObservationBundle:Observation')->findByOiseau($oiseau->getId());

        return [$oiseau, $observations];
    }

}