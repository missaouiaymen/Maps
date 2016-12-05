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
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\Paginator;


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
    public function ListAction($page)
    {
        $maxPays = $this->container->getParameter('max_pays_per_page');
        $pays_count = $this->getDoctrine()
            ->getRepository('FSPaysBundle:Pays')
            ->countPublishedTotal();
        $pagination = array(
            'page' => $page,
            'route' => 'article_list',
            'pages_count' => ceil($pays_count / $maxPays),
            'route_params' => array()
        );

        $pays = $this->getDoctrine()->getRepository('FSPaysBundle:Pays')
            ->getList($page, $maxPays);

        return $this->render('FSPaysBundle:Pays:list.html.twig', array(
            'pays' => $pays,
            'pagination' => $pagination
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
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(PaysType::class, $pays);
        if ($request->getMethod() == 'POST') {
            $pays->setOldPopulation($pays->getPopulation());
            $form->handleRequest($request);
            var_dump($pays->getPopulation());
            if ($form->isValid()) {
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



    public function countrylistAction(Request $request)
    {
         $em=$this->getDoctrine()->getManager();
        $ListPays = $em->getRepository('FSPaysBundle:Pays')
            ->findAll();

        $paginator  = $this->get("knp_paginator");
        $result=$paginator->paginate(
            $ListPays,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',5));

        return $this->render("FSPaysBundle:Pays:countrylis.html.twig", array(
            'ListPays' => $result,
        ));
    }

        }