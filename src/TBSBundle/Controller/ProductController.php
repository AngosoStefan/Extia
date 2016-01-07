<?php

namespace TBSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TBSBundle\Entity\Product;
use TBSBundle\Entity\Stock;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{

    public function indexAction(){
 
        return $this->render('TBSBundle:Product:index.html.twig');
    }


    public function addAction(Request $request){
        $p = new Product();
        $form = $this->createForm('TBSBundle\Form\ProductType', $p);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($p);
            $em->flush();   


            return $this->redirect($this->generateUrl("tbs_index"));
            

        }
       

        return $this->render('TBSBundle:Product:add.html.twig',array('form'=> $form->createView(),));
    }



}