<?php

namespace TBSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TBSBundle\Entity\Orderline; 
use TBSBundle\Entity\Basket; 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderlineController extends Controller
{

     public function addInOrderlineAction(Request $request, Basket $basket){

        // Boucle d'ajout de ligne
        $o = new Orderline();
        $form2 = $this->createForm('TBSBundle\Form\OrderlineType', $o);
        $form2->handleRequest($request);

        if ($form2->isSubmitted() && $form2->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $o->setBId($em->getRepository("TBSBundle:Basket")->find($basket->getBId()));
            $em->persist($o);

            // Finalisation de la commande
            $basket->setBStatus('sent');
            $em->persist($basket);
            $em->flush();   

            // Si le bouton valider est appuyé
            return $this->redirect($this->generateUrl("tbs_index"));
            
            // Si le bouton nouvelle ligne est appuyé
            // return $this->redirect($this->generateUrl("tbs_add_orderline"));
        }
       

        return $this->render('TBSBundle:Orderline:add.html.twig',array('form2'=> $form2->createView(),));
    }



}