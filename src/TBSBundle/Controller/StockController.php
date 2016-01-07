<?php

namespace TBSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TBSBundle\Entity\Stock;
use TBSBundle\Form\StockType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StockController extends Controller
{

    public function indexAction(){
 
        return $this->render('TBSBundle:Stock:index.html.twig');
    }


    public function addAction(Request $request){
        $s = new Stock();
        $form = $this->createForm('TBSBundle\Form\StockType', $s);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($s);
            $em->flush();   


            return $this->redirect($this->generateUrl("tbs_index"));
            

        }
       

        return $this->render('TBSBundle:Stock:add.html.twig',array('form'=> $form->createView(),));
    }



}