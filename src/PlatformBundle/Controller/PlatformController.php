<?php

namespace PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PlatformController extends Controller
{
    public function userProfilAction()
    {
        $array = $this->get('manage_platform')->platformProfil();


        return $this->render('PlatformBundle::profil.html.twig', array(
            'user' => $array[0],
            'observations' => $array[1]
        ));
    }

    public function profilEditAction()
    {
        $array = $this->get('manage_platform')->profilEdit();


        return $this->render('PlatformBundle::editprofil.html.twig', array(
            'user' => $array[0],
            'form' => $array[1]->createView()
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



    public function adminIndexAction()
    {
        $user = $this->get('manage_platform')->adminIndex();

        return $this->render('PlatformBundle::admin.html.twig', array(
           'user' => $user,
        ));
    }
}