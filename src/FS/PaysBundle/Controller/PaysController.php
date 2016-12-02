<?php
namespace FS\PaysBundle\Controller;
use FS\PaysBundle\Entity\Continent;
use FS\PaysBundle\Entity\Pays;
use FS\PaysBundle\Form\ContinentType;
use FS\PaysBundle\Form\PaysType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\Common\EventSubscriber;


/**
 * @param Request $request
 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
 */

class PaysController extends Controller
{
    public function indexAction($page)
    {
        if ($page < 1) {

            throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
        }



        $listContinent = $this->getDoctrine()
            ->getRepository('FSPaysBundle:Pays')
            ->findAll();


        return $this->render("FSPaysBundle:Pays:index.html.twig", array(
            'listContinent' => $listContinent,
        ));
    }

    public function viewAction($id)
    {
        $pays = $this->getDoctrine()
            ->getRepository('FSPaysBundle:Pays')
            ->find($id);

        return $this->render("FSPaysBundle:Pays:view.html.twig", array(
            'pays' => $pays,
        ));
    }

    public function addAction(Request $request)
    {
        $pays = new Pays();

        // On crée le FormBuilder grâce au service form factory
        $form = $this->createForm(PaysType::class,$pays);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($pays);

                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'pays bien  enregistrée');
                return $this->redirectToRoute('fs_pays_viewcountry', array('id' => $pays->getId()
                ));
            }
        }
        return $this->render('FSPaysBundle:Pays:add.html.twig', array('form' => $form->createView()));
    }

    public function editAction(Pays $pays,Request $request)
    {

        $form = $this->createForm(PaysType::class, $pays);
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($pays);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'pays bien  enregistrée');
                return $this->redirectToRoute('fs_pays_viewcountry', array('id' => $pays->getId()));
            }
        }
        return $this->render('FSPaysBundle:Pays:edit.html.twig',
            array('form' => $form->createView(),'id'=> $pays->getId()));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $req = $em->getRepository('FSPaysBundle:Pays')->find($id);

        if (!$req) {
            throw $this->createNotFoundException('No conti found for id ' . $id);
        }

        $em->remove($req);
        $em->flush();


        return new Response('Supression avec succée!');
    }

    public function menuAction($limit)
    {

        $listPays = array(
            array('id' => 2, 'nom' => 'France'),
            array('id' => 5, 'nom' => 'Algerie'),
            array('id' => 9, 'nom' => 'Serbie')
        );

        return $this->render('FSPaysBundle:Pays:menu.html.twig', array(

            'listPays' => $listPays
        ));
    }

    public function countrylistAction()
    {

        $ListPays = $this->getDoctrine()
            ->getRepository('FSPaysBundle:Pays')
            ->findAll();


        return $this->render("FSPaysBundle:Pays:countrylis.html.twig", array(
            'ListPays' => $ListPays,
        ));
    }

        }