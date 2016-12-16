<?php

namespace FS\UserBundle\Controller;

use FS\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * User controller.
 *
 */
class UserController extends Controller
{
    /**
     * Lists all user entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('FSUserBundle:User')->findAll();

        return $this->render('user/index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     */
    public function showAction(User $user)
    {

        return $this->render('user/show.html.twig', array(
            'user' => $user,
        ));
    }
}
