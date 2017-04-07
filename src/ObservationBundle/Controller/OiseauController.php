<?php

namespace ObservationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class OiseauController extends Controller
{
    public function indexAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            $search = $request->request->get('search');

            $oiseau = $this->getDoctrine()->getRepository('ObservationBundle:Oiseau')->findOneBy(
                array('name' => $search));

            return $this->redirectToRoute('oiseau_view', array('slug' => $oiseau->getSlug()));
        }

        $oiseaux = $this->getDoctrine()->getRepository('ObservationBundle:Oiseau')->findAll();

        return $this->render('ObservationBundle::index.html.twig', array (
            'oiseaux' => $oiseaux,
        ));

    }

    public function viewAction($slug)
    {

        $array = $this->get('manage_oiseau')->oiseauView($slug);

        return $this->render('ObservationBundle::view.html.twig', array(
            'oiseau' => $array[0],
            'observations' => $array[1]
        ));
    }
}
