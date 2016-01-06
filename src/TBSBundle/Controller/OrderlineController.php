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

        $o = new Orderline();
        $form2 = $this->createForm('TBSBundle\Form\OrderlineType', $o);
        $form2->handleRequest($request);

        if ($form2->isSubmitted() && $form2->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $o->setBId($em->getRepository("TBSBundle:Basket")->find($basket->getBId()));
            $em->persist($o);
            $em->flush();   


            return $this->redirect($this->generateUrl("tbs_index"));
            

        }
       

        return $this->render('TBSBundle:Orderline:add.html.twig',array('form2'=> $form2->createView(),));
    }



}