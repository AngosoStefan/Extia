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
    /*Ajout d'une ligne de commande*/
    public function addInOrderlineAction(Request $request, Basket $basket){

        $o = new Orderline();//Nouvelle ligne de commande
        $form2 = $this->createForm('TBSBundle\Form\OrderlineType', $o);//formulaire pour nouvelle ligne commande
        $form2->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $count = 0;


        $orderlines = $em->getRepository("TBSBundle:Orderline")->findByBId($basket->getBId());
        $locations = $em->getRepository("TBSBundle:Location")->findAll();

        /*Récuperation du nombre de produit*/
        foreach ($orderlines as $orderline) {
            $count = ($count) + ($orderline->getOlQtt());
        }
        $count = $count + $o->getOlQtt();


        if(isset($_POST['final']))
        {
            /*Vérification si le pannier est vide*/
            if ($orderlines == null)
            {
               echo "Panier vide";
               return $this->render('TBSBundle:Orderline:add.html.twig',array('form2'=> $form2->createView(), 'basket'=> $basket ,'orderlines'=> $orderlines,));
            }
            //
            return $this->render('TBSBundle:Orderline:confirmation.html.twig',array('basket'=> $basket,'locations'=>$locations,'orderlines'=> $orderlines,));

        }
        
        /*Enregistrement d'une nouvelle ligne de commande*/
        if ($form2->isSubmitted() && $form2->isValid()) {    

            $em = $this->getDoctrine()->getManager();
             

            //$count = $em->getRepository("TBSBundle:Orderline")->countOrderlines($basket->getBId());
            //echo $count;
            
            $o->setBId($em->getRepository("TBSBundle:Basket")->find($basket->getBId()));

            $pid = $o->getPId();

            $product = $em->getRepository("TBSBundle:Product")->findOneByPId($pid);

            /*Diminution du stock appartenant au produit commandé*/
            $stock = $em->getRepository("TBSBundle:Stock")->findOneBySId($product->getSId());

            $new_stock = $stock->getSTotal() - ($o->getOlQtt() * $product->getPUnit());

            /*On teste si la totalité de la commande est supérieure à 4*/
            if($count>4 || ($o->getOlQtt() <= 0) || $new_stock < 0)
            {
                $orderlines = $em->getRepository("TBSBundle:Orderline")->findByBId($basket->getBId());  
                echo "We cant process your order";
                return $this->render('TBSBundle:Orderline:add.html.twig',array('form2'=> $form2->createView(), 'basket'=> $basket ,'orderlines'=> $orderlines,'locations'=>$locations));

            }


            $stock->setSTotal($new_stock); //Enregistrement du stock modifié

            $em->persist($o);
            $em->persist($stock);

            $em->flush();   


            $orderlines = $em->getRepository("TBSBundle:Orderline")->findByBId($basket->getBId());
            // Si le bouton valider est appuyé
            return $this->render('TBSBundle:Orderline:add.html.twig',array('form2'=> $form2->createView(), 'basket'=> $basket ,'orderlines'=> $orderlines,'locations'=>$locations
                ));
            
        }
        

        return $this->render('TBSBundle:Orderline:add.html.twig',array('form2'=> $form2->createView(), 'basket'=> $basket,'locations'=>$locations));
    }

    /*Supression d'une ligne commande*/
    public function deleteAction(Orderline $order,Request $request){


        $em = $this->getDoctrine()->getEntityManager();

        $basket = $em->getRepository("TBSBundle:Basket")->find($order->getBId());


        $pid = $order->getPId();

        $product = $em->getRepository("TBSBundle:Product")->findOneByPId($pid);//Récupération du produit à supprimer

        /*Augmentation du stock appartenant au produit à supprimer*/
        $stock = $em->getRepository("TBSBundle:Stock")->findOneBySId($product->getSId());

        $new_stock = $stock->getSTotal() + ($order->getOlQtt() * $product->getPUnit());

        $stock->setSTotal($new_stock);

        $em->remove($order); //Supression du produit
        $em->persist($stock);

        $em->flush();

        $o = new Orderline();
        $orderlines = $em->getRepository("TBSBundle:Orderline")->findByBId($basket->getBId());

        $form2 = $this->createForm('TBSBundle\Form\OrderlineType', $o);
        $form2->handleRequest($request);
        return $this->render('TBSBundle:Orderline:add.html.twig',array('form2'=> $form2->createView(), 'basket'=> $basket ,'orderlines'=> $orderlines,));

     }

}