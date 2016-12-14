<?php
namespace FS\PaysBundle\Controller;
use FS\PaysBundle\Entity\Continent;
use FS\PaysBundle\Entity\Pays;
use FS\PaysBundle\Form\ContinentType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
/**
 * @param Request $request
 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
 */

class ContinentController extends Controller
{
    public function indexAction($page)
    {
        if ($page < 1) {

            throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
        }
        $listContinent = $this->getDoctrine()
            ->getRepository('FSPaysBundle:Continent')
            ->findAll();


        return $this->render("FSPaysBundle:Continent:index.html.twig", array(
            'listContinent' => $listContinent,
        ));
    }
    public function continentlistAction()
    {
        $listContinent = $this->getDoctrine()
            ->getRepository('FSPaysBundle:Continent')
            ->findAll();


        return $this->render("FSPaysBundle:Continent:continentlist.html.twig", array(
            'listContinent' => $listContinent,
        ));
    }
    public function viewcontinentAction($id)
    {
        $continent = $this->getDoctrine()
            ->getRepository('FSPaysBundle:Continent')
            ->find($id);

        return $this->render("FSPaysBundle:Continent:view.html.twig", array(
            'continent' => $continent,
        ));
    }


    public function addAction(Request $request)
    {
       if(!$this->get('security.authorization_checker')->isGranted('ROLE_AUTEUR'))
       { throw new AccessDeniedException('Accés limité aux auteurs.');}
        $continent = new Continent();
            $form = $this->createForm(ContinentType::class,$continent);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($continent);
                $em->flush();
                $request->getSession()->getFlashBag()->add('success', 'Successfully registered continent');

                return $this->redirectToRoute('fs_pays_continentlist');
            }
        }
        return $this->render('FSPaysBundle:Continent:add.html.twig', array('form' => $form->createView()));
    }

    public function editAction(Continent $continent,Request $request)
    {
        $form = $this->createForm(ContinentType::class, $continent);
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($continent);
                $em->flush();
                $request->getSession()->getFlashBag()->add('success', 'Successfully Modified continent');
                return $this->redirectToRoute('fs_pays_continentlist');
            }
        }
        return $this->render('FSPaysBundle:Continent:edit.html.twig',
            array('form' => $form->createView(),'id'=> $continent->getId()));
    }

    public function deleteAction($id ,Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $req = $em->getRepository('FSPaysBundle:Continent')->find($id);

        if (!$req) {
            throw $this->createNotFoundException('No conti found for id ' . $id);
        }

        $em->remove($req);
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'Successfully Removed continent');
        return $this->redirectToRoute('fs_pays_continentlist');

    }



}