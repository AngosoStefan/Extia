<?php

namespace TBSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TBSBundle\Entity\Orderline; 
use TBSBundle\Entity\Basket; 
use TBSBundle\Entity\Location;
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


        $ols = $em->getRepository("TBSBundle:Orderline")->findByBId($basket->getBId());
        $locations = $em->getRepository("TBSBundle:Location")->findAll();

        foreach ($ols as $ol) {
            // $advert est une instance de Advert
            $count = ($count) + ($ol->getOlQtt());
            // echo $count;
        }
        $count = $count + $o->getOlQtt();


        if(isset($_POST['final']))
        {
            
            $o->setBId($em->getRepository("TBSBundle:Basket")->find($basket->getBId()));

            if($o->getOlQtt() != 0)
            {
                $test = $o->getPId();

                $product = $em->getRepository("TBSBundle:Product")->findOneByPId($test);

                $stock = $em->getRepository("TBSBundle:Stock")->findOneBySId($product->getSId());

                $new_stock = $stock->getSTotal() - ($o->getOlQtt() * $product->getPUnit());

                if($count>4  || $new_stock < 0 )
                {
                    $orderlines = $em->getRepository("TBSBundle:Orderline")->findByBId($basket->getBId());  
                    echo "We cant process your order";
                    return $this->render('TBSBundle:Orderline:add.html.twig',array('form2'=> $form2->createView(), 'basket'=> $basket ,'orderlines'=> $orderlines,'locations'=>$locations));
                }

                $stock->setSTotal($new_stock);

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
            
            $o->setBId($em->getRepository("TBSBundle:Basket")->find($basket->getBId()));

            $test = $o->getPId();

            $product = $em->getRepository("TBSBundle:Product")->findOneByPId($test);

            $stock = $em->getRepository("TBSBundle:Stock")->findOneBySId($product->getSId());

            $new_stock = $stock->getSTotal() - ($o->getOlQtt() * $product->getPUnit());

            if($count>4 || ($o->getOlQtt() == 0) || $new_stock < 0)
            {
                $orderlines = $em->getRepository("TBSBundle:Orderline")->findByBId($basket->getBId());  
                echo "We cant process your order";
                return $this->render('TBSBundle:Orderline:add.html.twig',array('form2'=> $form2->createView(), 'basket'=> $basket ,'orderlines'=> $orderlines,'locations'=>$locations));

            }


            $stock->setSTotal($new_stock);


            
            $em->persist($o);
            $em->persist($stock);

            // Finalisation de la commande
            //$basket->setBStatus('sent');
            //$em->persist($basket);
            $em->flush();   


            $orderlines = $em->getRepository("TBSBundle:Orderline")->findByBId($basket->getBId());
            // Si le bouton valider est appuyé
            return $this->render('TBSBundle:Orderline:add.html.twig',array('form2'=> $form2->createView(), 'basket'=> $basket ,'orderlines'=> $orderlines,'locations'=>$locations
                ));
            
            // Si le bouton nouvelle ligne est appuyé
            // return $this->redirect($this->generateUrl("tbs_add_orderline"));
        }
        

        return $this->render('TBSBundle:Orderline:add.html.twig',array('form2'=> $form2->createView(), 'basket'=> $basket,'locations'=>$locations));
    }



}