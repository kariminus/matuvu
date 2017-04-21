<?php

namespace ObservationBundle\Oiseau;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

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

        $oiseaux = $this->serializer();

        $request = $this->requestStack->getCurrentRequest();
        $error = false;
        if ($request->isMethod('POST')) {

            $oiseau = $this->em->getRepository('ObservationBundle:Oiseau')->findOneBy(
                array('name' => $request->request->get('search')));

            try {
                $response = new RedirectResponse($this->router->generate('oiseau_view', array('slug' => $oiseau->getSlug())));

                $response->send();
            }
            catch (\Error $e){
                $error = "Aucun oiseau trouvé";
            }
        }

        return [$oiseaux, $error];

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

        /*** Cherche si l'oiseau est une espece protégée */
        $protected = $this->em->getRepository('ObservationBundle:EspeceProtegee')->findOneBy(
            array('id' => $oiseau->getId()));

        $oiseaux = $this->serializer();

        $observation = null;

        try {
            $observation = $this->em->getRepository('ObservationBundle:Observation')->findImage($oiseau->getId());
        }
        catch (\Error $e){
            $error = "Problème";
        }


        /** Récupére toutes les observations validées pour un oiseau */
        $observations = $this->em->getRepository('ObservationBundle:Observation')->findBy(array(
            'oiseau' => $oiseau->getId(),
            'validated' => 1
        ));

        $request = $this->requestStack->getCurrentRequest();
        $error = false;
        if ($request->isMethod('POST')) {

            $newOiseau = $this->em->getRepository('ObservationBundle:Oiseau')->findOneBy(
                array('name' => $request->request->get('search')));

            try {
                $response = new RedirectResponse($this->router->generate('oiseau_view', array('slug' => $newOiseau->getSlug())));

                $response->send();
            }
            catch (\Error $e){
                $error = "Aucun oiseau trouvé";
            }


        }

        return [$oiseau, $protected, $oiseaux, $observations, $observation, $error];
    }

    /*** Récupére les noms uniques des oiseaux et renvoi au format json*/
    public function serializer()
    {
        $oiseaux = $this->em->getRepository('ObservationBundle:Oiseau')->myFindAll();
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);

        $uniques = $this->unique_multidim_array($oiseaux,'name');

        $data = $serializer->serialize($uniques, 'json');

        return $data;
    }

    function unique_multidim_array($array, $key) {
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }



}