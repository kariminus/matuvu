<?php

namespace PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PlatformController extends Controller
{
    public function userProfilAction()
    {
        $user = $this->get('manage_platform')->platformProfil();

        return $this->render('PlatformBundle::profil.html.twig', array(
            'user' => $user,
        ));
    }

    public function userObservationsAction()
    {
        $array = $this->get('manage_platform')->platformObservations();

        return $this->render('PlatformBundle::observations.html.twig', array(
            'user' => $array[0],
            'observations' => $array[1],
        ));
    }

    public function observationViewAction($id)
    {
        $array = $this->get('manage_platform')->observationView($id);

        return $this->render('PlatformBundle::observation.html.twig', array(
            'user' => $array[0],
            'observation' => $array[1],
            'oiseau' => $array[2]
        ));
    }

    public function adminIndexAction()
    {
        $user = $this->get('manage_platform')->adminIndex();

        return $this->render('PlatformBundle::admin.html.twig', array(
           'user' => $user,
        ));
    }
}