<?php

namespace TBSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TBSBundle\Entity\Basket;
use TBSBundle\Entity\Orderline;
use TBSBundle\Form\BasketType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BasketController extends Controller
{

     public function addInBasketAction(Request $request){
        $em = $this->getDoctrine()->getManager();

        $b = new Basket();
        $form = $this->createForm('TBSBundle\Form\BasketType', $b);
        $form->handleRequest($request);

        $o = new Orderline();
        $form2 = $this->createForm('TBSBundle\Form\OrderlineType', $o);
        $form2->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            //echo $form['bFloor']->getData();

            $em = $this->getDoctrine()->getManager();
            $b->setBFloor('4th');
            $em->persist($b);
            $em->flush();   
            //echo $b->getBId();

            return $this->render('TBSBundle:Orderline:add.html.twig',array('form2'=> $form2->createView(), 'basket'=> $b ,));
            

        }
       

        return $this->render('TBSBundle:Basket:add.html.twig',array('form'=> $form->createView(),));
    }



}