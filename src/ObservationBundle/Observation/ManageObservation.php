<?php

namespace ObservationBundle\Observation;

use Doctrine\ORM\EntityManager;
use ObservationBundle\Form\ObservationType;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use ObservationBundle\Entity\Observation;

class ManageObservation
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

    /**
     * Ajoute une observation
     * @param $slug
     * @return array
     */
    public function observationAdd($slug)
    {
        $request = $this->requestStack->getCurrentRequest();
        $user = $this->tokenStorage->getToken()->getUser();
        $oiseau = $this->em->getRepository('ObservationBundle:Oiseau')->findOneBy(
            array('slug' => $slug));
        $exist = $this->em->getRepository('ObservationBundle:Observation')->findDistinct($user->getId(), $oiseau->getId());

        $image = $this->em->getRepository('ObservationBundle:Observation')->findImage( $oiseau->getId());

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
            if ($exist == 0)
            {
                $user->addObservationsNumber();
                $this->em->flush();
            }

            $response = new RedirectResponse($this->router->generate('confirmation'));

            $response->send();
        }

<<<<<<< HEAD
        return [$form, $oiseau];
=======
        return [$form, $oiseau, $image];
>>>>>>> karim
    }

    /**
     * Affiche le détail d'une observation
     * @param $id
     * @return array
     */
    public function observationView($id)
    {
        $observation = $this->em->getRepository('ObservationBundle:Observation')->findOneById($id);
        $oiseau = $observation->getOiseau();

        return [$observation, $oiseau];
    }

    /**
     * Supprime une observation
     * @param $id
     */
    public function observationDelete($id)
    {
        $response = new RedirectResponse($this->router->generate('user_profil'));

        $observation = $this->em->getRepository('ObservationBundle:Observation')->find($id);
        if ($observation === null) {
            $response->send();
        }
        $this->em->remove($observation);
        $this->em->flush();
        $response->send();
    }

    /**
     * Supprime l'image d'une observation
     * @param $id
     */
    public function imageDelete($id)
    {
        $observation = $this->em->getRepository('ObservationBundle:Observation')->find($id);

        $observation->setImageName(null);
        $this->em->persist($observation);
        $this->em->flush();
    }

    /**
     * Valide une observation
     * @param $id
     */
    public function observationValidate($id)
    {
        $observation = $this->em->getRepository('ObservationBundle:Observation')->find($id);
        $observation->setValidated(1);
        $this->em->persist($observation);
        $this->em->flush();
    }

}