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
        $ols = new Orderline();
        $form2 = $this->createForm('TBSBundle\Form\OrderlineType', $o);
        $form2->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $count = 0;


        //$count = $em->getRepository("TBSBundle:Orderline")->countOrderlines($basket->getBId());
        //echo $count;

        if(isset($_POST['final']))
        {
            
            $o->setBId($em->getRepository("TBSBundle:Basket")->find($basket->getBId()));

            if($o->getOlQtt() != 0)
            {
                $test = $o->getPId();

                $product = $em->getRepository("TBSBundle:Product")->findOneByPId($test);

                $stock = $em->getRepository("TBSBundle:Stock")->findOneBySId($product->getSId());

                $new_stock = $stock->getSTotal() - ($o->getOlQtt() * $product->getPUnit());

                $stock->setSTotal($new_stock);

                $o->setTest($stock->getSId());

                
                $em->persist($o);
                $em->persist($stock);
            }

            

            // Finalisation de la commande
            $basket->setBStatus('sent');
            $em->persist($basket);
            $em->flush();   

            return $this->redirect($this->generateUrl("tbs_index"));

        }
        if ($form2->isSubmitted() && $form2->isValid()) {    





            $em = $this->getDoctrine()->getManager();
             

            //$count = $em->getRepository("TBSBundle:Orderline")->countOrderlines($basket->getBId());
            //echo $count;


            $ols = $em->getRepository("TBSBundle:Orderline")->findByBId($basket->getBId());

            foreach ($ols as $ol) {
                // $advert est une instance de Advert
                $count = ($count) + ($ol->getOlQtt());
                // echo $count;
            }
            $count = $count + $o->getOlQtt();

            if($count>4 || ($o->getOlQtt() == 0))
            {
                $orderlines = $em->getRepository("TBSBundle:Orderline")->findByBId($basket->getBId());  
                echo "We cant process your order";
                return $this->render('TBSBundle:Orderline:add2.html.twig',array('form2'=> $form2->createView(), 'basket'=> $basket ,'orderlines'=> $orderlines,));

            }

            $o->setBId($em->getRepository("TBSBundle:Basket")->find($basket->getBId()));

            $test = $o->getPId();

            $product = $em->getRepository("TBSBundle:Product")->findOneByPId($test);

            $stock = $em->getRepository("TBSBundle:Stock")->findOneBySId($product->getSId());

            $new_stock = $stock->getSTotal() - ($o->getOlQtt() * $product->getPUnit());

            $stock->setSTotal($new_stock);

            $o->setTest($stock->getSId());

            
            $em->persist($o);
            $em->persist($stock);

            // Finalisation de la commande
            //$basket->setBStatus('sent');
            //$em->persist($basket);
            $em->flush();   


            $orderlines = $em->getRepository("TBSBundle:Orderline")->findByBId($basket->getBId());
            // Si le bouton valider est appuyé
            return $this->render('TBSBundle:Orderline:add2.html.twig',array('form2'=> $form2->createView(), 'basket'=> $basket ,'orderlines'=> $orderlines,));
            
            // Si le bouton nouvelle ligne est appuyé
            // return $this->redirect($this->generateUrl("tbs_add_orderline"));
        }
        

        return $this->render('TBSBundle:Orderline:add.html.twig',array('form2'=> $form2->createView(), 'basket'=> $basket));
    }



}