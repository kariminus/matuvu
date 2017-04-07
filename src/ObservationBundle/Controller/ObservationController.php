<?php

namespace ObservationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ObservationController extends Controller
{
    public function showAction($id)
    {
        $array = $this->get('manage_observation')->observationShow($id);
        return $this->render('ObservationBundle::show.html.twig', array(
            'user' => $array[0],
            'observation' => $array[1],
        ));
    }

    public function viewAction($id)
    {
        $array = $this->get('manage_observation')->observationView($id);

        return $this->render('PlatformBundle::observation.html.twig', array(
            'user' => $array[0],
            'observation' => $array[1],
            'oiseau' => $array[2]
        ));
    }

    public function addAction($slug)
    {

        $array = $this->get('manage_observation')->observationAdd($slug);

        return $this->render('ObservationBundle::add.html.twig', array(
            'form' => $array[0]->createView(),
            'oiseau' => $array[1]
        ));
    }

    public function deleteAction($id)
    {
        $this->get('manage_observation')->observationDelete($id);
        return $this->redirectToRoute('user_profil');
    }

    public function imageDeleteAction($id)
    {
        $this->get('manage_observation')->imageDelete($id);
        return $this->redirectToRoute('user_profil');
    }

    public function validateAction($id)
    {
        $this->get('manage_observation')->observationValidate($id);
        return $this->redirectToRoute('user_profil');
    }
}
