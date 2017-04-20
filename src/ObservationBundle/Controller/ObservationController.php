<?php

namespace ObservationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ObservationController extends Controller
{
    /**
     * Affiche le détail d'une observation
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($id)
    {
        $array = $this->get('manage_observation')->observationView($id);

        return $this->render('PlatformBundle::observation.html.twig', array(
            'observation' => $array[0],
            'oiseau' => $array[1]
        ));
    }

    /**
     * Ajout d'une observation
     * @param $slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction($slug)
    {

        $array = $this->get('manage_observation')->observationAdd($slug);

        return $this->render('ObservationBundle::add.html.twig', array(
            'form' => $array[0]->createView(),
            'oiseau' => $array[1],
            'observation' => $array[2],
        ));
    }

    /**
     * Supprime une observation
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($id)
    {
        $this->get('manage_observation')->observationDelete($id);
        return $this->redirectToRoute('user_profil');
    }

    /**
     * Supprime l'image d'une observation
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function imageDeleteAction($id)
    {
        $this->get('manage_observation')->imageDelete($id);
        return $this->redirectToRoute('user_profil');
    }

    /**
     * Valide une observation
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function validateAction($id)
    {
        $this->get('manage_observation')->observationValidate($id);
        return $this->redirectToRoute('user_profil');
    }

    /**
     * Affiche la page de confirmation
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function confirmationAction()
    {
        return $this->render('ObservationBundle::confirmation.html.twig');
    }
}
