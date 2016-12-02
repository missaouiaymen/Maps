<?php

namespace FS\PaysBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FSPaysBundle:Pays:index.html.twig');
    }
    public function viewAction($id)
    {
        return new Response("Affichage de pays d'id :".$id);
    }


    public function homeAction(Request $request){
        return $this->render('FSPaysBundle:Home:home.html.twig');
    }

}
