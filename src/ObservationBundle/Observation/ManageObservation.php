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

    public function observationDelete($id)
    {
        $observation = $this->em->getRepository('ObsevationBundle:Observation')->find($id);
        if ($observation === null) {
            return $this->router->generate('homepage');
        }
        $this->em->remove($observation);
        $this->em->flush();
    }

    public function observationValidate($id)
    {

    }

}