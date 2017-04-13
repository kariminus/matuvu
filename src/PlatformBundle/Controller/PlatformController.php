<?php

namespace PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
     * Affiche les observations en attente des membres
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function userPendingAction(Request $request)
    {
        $observations = $this->get('manage_platform')->platformPending();

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator  = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $observations,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 8)
        );

        return $this->render('PlatformBundle::pending.html.twig', array(
            'observations' => $result
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
    public function userObservationsAction(Request $request)
    {
        $array = $this->get('manage_platform')->platformObservations();

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator  = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $array[1],
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 8)
        );

        return $this->render('PlatformBundle::observations.html.twig', array(
            'user' => $array[0],
            'observations' => $result,
        ));
    }
}