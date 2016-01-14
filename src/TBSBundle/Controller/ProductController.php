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

    public function productsAction(){
 
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository("TBSBundle:Product")->findAll();
        return $this->render('TBSBundle:Product:products.html.twig',array('products'=>$products));
    }

    public function editAction(Request $request, Product $product){
 
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm('TBSBundle\Form\ProductType', $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();   


            return $this->redirect($this->generateUrl("tbs_index"));
            

        }
        return $this->render('TBSBundle:Product:edit.html.twig',array('form'=> $form->createView(), 'product'=> $product,));
    }

    public function deleteAction(Product $product){
 
        $em = $this->getDoctrine()->getManager();

        $em->remove($product);
        $em->flush();

        return $this->redirect($this->generateUrl("tbs_products"));
    }




}