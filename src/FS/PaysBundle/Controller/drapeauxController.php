<?php

namespace FS\PaysBundle\Controller;

use FS\PaysBundle\Entity\drapeaux;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Drapeaux controller.
 *
 */
class drapeauxController extends Controller
{
    /**
     * Lists all drapeaux entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $drapeauxes = $em->getRepository('FSPaysBundle:drapeaux')->findAll();

        return $this->render('drapeaux/index.html.twig', array(
            'drapeauxes' => $drapeauxes,
        ));
    }

    /**
     * Finds and displays a drapeaux entity.
     *
     */
    public function showAction(drapeaux $drapeaux)
    {

        return $this->render('drapeaux/show.html.twig', array(
            'drapeaux' => $drapeaux,
        ));
    }
}
