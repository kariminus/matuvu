<?php

namespace PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PlatformController extends Controller
{
    /**
     * Affiche le profil des membres
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function userProfilAction()
    {
        $observations = $this->get('manage_platform')->platformProfil();


        return $this->render('PlatformBundle::profil.html.twig', array(
            'observations' => $observations
        ));
    }

    /**
     * Permet à l'utiisateur de modifier son profil
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function profilEditAction()
    {
        $array = $this->get('manage_platform')->profilEdit();


        return $this->render('PlatformBundle::editprofil.html.twig', array(
            'user' => $array[0],
            'form' => $array[1]->createView()
        ));
    }

    /**
     * Affiche les observations d'un membre
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function userObservationsAction()
    {
        $array = $this->get('manage_platform')->platformObservations();

        return $this->render('PlatformBundle::observations.html.twig', array(
            'user' => $array[0],
            'observations' => $array[1],
        ));
    }
}