<?php

namespace ObservationBundle\Oiseau;

use Doctrine\ORM\EntityManager;
use ObservationBundle\Form\ObservationType;
use Symfony\Component\HttpFoundation\RequestStack;
use ObservationBundle\Entity\Observation;

class ManageOiseau
{
    private $em;

    public function __construct(EntityManager $em, $formFactory, $router, RequestStack $requestStack)
    {
        $this->em = $em;
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->requestStack = $requestStack;
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
        $oiseau = $this->em->getRepository('ObservationBundle:Oiseau')->findOneBy(
            array('slug' => $slug));

        $observation = new Observation();
        $form   = $this->formFactory->create(ObservationType::class, $observation);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $observation->setOiseau($oiseau);
            $this->em->persist($observation);
            $this->em->flush();
        }

        return [$form, $oiseau];
    }

}