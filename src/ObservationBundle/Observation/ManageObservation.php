<?php

namespace ObservationBundle\Observation;

use Doctrine\ORM\EntityManager;
use ObservationBundle\Form\ObservationType;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use ObservationBundle\Entity\Observation;

class ManageObservation
{
    private $em;

    private $router;

    private $formFactory;

    protected $requestStack;

    protected $tokenStorage;


    public function __construct(EntityManager $em, $formFactory, $router, RequestStack $requestStack, TokenStorage $tokenStorage)
    {
        $this->em = $em;
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->requestStack = $requestStack;
        $this->tokenStorage = $tokenStorage;
    }


    public function observationShow($id)
    {
        $user = $this->tokenStorage->getToken()->getUser();

        $observation = $this->em->getRepository('ObservationBundle:Observation')->findOne($id);

        return [$user, $observation];

    }

    public function observationView($id)
    {
        $user = $this->tokenStorage->getToken()->getUser();

        $observation = $this->em->getRepository('ObservationBundle:Observation')->findOneById($id);
        $oiseau = $observation->getOiseau();

        return [$user, $observation, $oiseau];
    }

    public function observationDelete($id)
    {
        $observation = $this->em->getRepository('ObservationBundle:Observation')->find($id);
        if ($observation === null) {
            return $this->router->generate('user_profil');
        }
        $this->em->remove($observation);
        $this->em->flush();
    }

    public function observationValidate($id)
    {
        $observation = $this->em->getRepository('ObservationBundle:Observation')->find($id);
        $observation->setValidated(1);
        $this->em->persist($observation);
        $this->em->flush();
    }

}