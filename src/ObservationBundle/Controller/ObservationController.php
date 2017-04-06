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

    public function deleteAction($id)
    {
        $this->get('manage_observation')->observationDelete($id);
        return $this->redirectToRoute('admin');
    }
}
