<?php

namespace TBSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TBSBundle\Entity\Basket;
use TBSBundle\Entity\Orderline;
use TBSBundle\Entity\User;
use TBSBundle\Form\BasketType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BasketController extends Controller
{

     public function addInBasketAction(Request $request,User $user){
        $em = $this->getDoctrine()->getManager();

        $b = new Basket();
        $form = $this->createForm('TBSBundle\Form\BasketType', $b);
        $form->handleRequest($request);

        $o = new Orderline();
        $form2 = $this->createForm('TBSBundle\Form\OrderlineType', $o);
        $form2->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            //echo $form['bFloor']->getData();
            $b->setId($em->getRepository("TBSBundle:User")->find($user->getId()));
            $em = $this->getDoctrine()->getManager();
            $em->persist($b);
            $em->flush();   
            //echo $b->getBId();

            return $this->render('TBSBundle:Orderline:add.html.twig',array('form2'=> $form2->createView(), 'basket'=> $b ,));
            

        }
       

        return $this->render('TBSBundle:Basket:add.html.twig',array('form'=> $form->createView(),));
    }



}