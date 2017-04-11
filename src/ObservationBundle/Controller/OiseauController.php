<?php

namespace ObservationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class OiseauController extends Controller
{
    /**
     * Page d'accueil du site
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $array = $this->get('manage_oiseau')->oiseauIndex();
        return $this->render('ObservationBundle::index.html.twig', array (
            'oiseaux' => $array[0],
            'error' => $array[1]
        ));

    }

    /**
     * Page de profil d'un oiseau avec ses observations
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($slug)
    {

        $array = $this->get('manage_oiseau')->oiseauView($slug);

        return $this->render('ObservationBundle::view.html.twig', array(
            'oiseau' => $array[0],
            'observations' => $array[1],
            'observation' => $array[2]
        ));
    }
}
