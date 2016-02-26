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
        $form2 = $this->createForm('TBSBundle\Form\OrderlineType', $o);
        $form2->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $count = 0;


        $orderlines = $em->getRepository("TBSBundle:Orderline")->findByBId($basket->getBId());
        $locations = $em->getRepository("TBSBundle:Location")->findAll();

        foreach ($orderlines as $orderline) {
            $count = ($count) + ($orderline->getOlQtt());
            // echo $count;
        }
        $count = $count + $o->getOlQtt();


        if(isset($_POST['final']))
        {
            if ($orderlines == null)
            {
               echo "Panier vide";
               return $this->render('TBSBundle:Orderline:add.html.twig',array('form2'=> $form2->createView(), 'basket'=> $basket ,'orderlines'=> $orderlines,));
            }
            //
            return $this->render('TBSBundle:Orderline:confirmation.html.twig',array('basket'=> $basket,'locations'=>$locations,'orderlines'=> $orderlines,));

        }
        

        if ($form2->isSubmitted() && $form2->isValid()) {    

            $em = $this->getDoctrine()->getManager();
             

            //$count = $em->getRepository("TBSBundle:Orderline")->countOrderlines($basket->getBId());
            //echo $count;
            
            $o->setBId($em->getRepository("TBSBundle:Basket")->find($basket->getBId()));

            $pid = $o->getPId();

            $product = $em->getRepository("TBSBundle:Product")->findOneByPId($pid);

            $stock = $em->getRepository("TBSBundle:Stock")->findOneBySId($product->getSId());

            $new_stock = $stock->getSTotal() - ($o->getOlQtt() * $product->getPUnit());

            if($count>4 || ($o->getOlQtt() <= 0) || $new_stock < 0)
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
            
        }
        

        return $this->render('TBSBundle:Orderline:add.html.twig',array('form2'=> $form2->createView(), 'basket'=> $basket,'locations'=>$locations));
    }


    public function deleteAction(Orderline $order,Request $request){


        $em = $this->getDoctrine()->getEntityManager();

        $basket = $em->getRepository("TBSBundle:Basket")->find($order->getBId());

        $em->remove($order);
        $em->flush();

        $o = new Orderline();
        $orderlines = $em->getRepository("TBSBundle:Orderline")->findByBId($basket->getBId());

        $form2 = $this->createForm('TBSBundle\Form\OrderlineType', $o);
        $form2->handleRequest($request);
        return $this->render('TBSBundle:Orderline:add.html.twig',array('form2'=> $form2->createView(), 'basket'=> $basket ,'orderlines'=> $orderlines,));

     }

}