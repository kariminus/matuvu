<?php

namespace ObservationBundle\Oiseau;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\HttpFoundation\RedirectResponse;

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

    /**
     * Accueil du site
     * @return array
     *
     */
    public function oiseauIndex()
    {
        $request = $this->requestStack->getCurrentRequest();
        if ($request->isMethod('POST')) {

            $oiseau = $this->em->getRepository('ObservationBundle:Oiseau')->findOneBy(
                array('name' => $request->request->get('search')));

            $response = new RedirectResponse($this->router->generate('oiseau_view', array('slug' =>$oiseau->getSlug())));

            $response->send();

        }

        return $this->em->getRepository('ObservationBundle:Oiseau')->findAll();

    }

    /**
     * Page de profil d'un oiseau
     * @param $slug
     * @return array
     */
    public function oiseauView($slug)
    {
        $oiseau = $this->em->getRepository('ObservationBundle:Oiseau')->findOneBy(
            array('slug' => $slug));

        $observations = $this->em->getRepository('ObservationBundle:Observation')->findBy(array(
            'oiseau' => $oiseau->getId(),
            'validated' => 1
        ));

        $request = $this->requestStack->getCurrentRequest();
        if ($request->isMethod('POST')) {

            $oiseau = $this->em->getRepository('ObservationBundle:Oiseau')->findOneBy(
                array('name' => $request->request->get('search')));

            $response = new RedirectResponse($this->router->generate('oiseau_view', array('slug' =>$oiseau->getSlug())));

            $response->send();

        }

        return [$oiseau, $observations];
    }

}