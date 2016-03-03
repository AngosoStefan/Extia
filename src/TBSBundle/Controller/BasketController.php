<?php

namespace TBSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TBSBundle\Entity\Basket;
use TBSBundle\Entity\Orderline;
use TBSBundle\Entity\User;
use TBSBundle\Entity\Location;
use TBSBundle\Form\BasketType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/*Gestion du panier*/

class BasketController extends Controller
{

    /*Fonction pour ajout de la salle et l'étage pour le panier*/
    public function addInBasketAction(Request $request,User $user){
        $em = $this->getDoctrine()->getManager();

        $b = new Basket();//Création d'un nouveau panier
        $form = $this->createForm('TBSBundle\Form\BasketType', $b); //Création formulaire pour le pannier

        $o = new Orderline();//Création d'une nouvelle commande 
        $form2 = $this->createForm('TBSBundle\Form\OrderlineType', $o);
        $form2->handleRequest($request);


        $locations = $em->getRepository("TBSBundle:Location")->findAll();//Récupération de toutes les salles

        $orderlines = NULL;

        /* On combine un formulaire symfony et un formulaire fait main 
        On ne peut donc pas utiliser isValid() pour la validation du formulaire, on le test à la main */

        $form->handleRequest($request);

        if (isset($_POST['lfinal'])) {
            $location = $_POST['lfinal'];
        }

        if ($form->isSubmitted() && $location != 0) { //Vérification des données entrées pour la création du panier

            $b->setLId($em->getRepository("TBSBundle:Location")->find($location)); //Sauvegarde de la position pour la livraison
            $b->setId($em->getRepository("TBSBundle:User")->find($user->getId())); //Sauvegarde de la personne pour la livraison
            $b->setBStatus('filling');  // Etat en cours de remplissage pour le panier
            
            /*Ecriture des informations du panier dans la base de données*/
            $em->persist($b);
            $em->flush();   

            return $this->render('TBSBundle:Orderline:add.html.twig',array('form2'=> $form2->createView(), 'basket'=> $b, 'locations'=> $locations,'orderlines'=> $orderlines ));
        }
       

        return $this->render('TBSBundle:Basket:add.html.twig',array('form'=> $form->createView(),));//envoie vers le formulaore
    }

    /*Supression du panier lorsque la commande est annulée*/
    public function deleteAction(Basket $basket){


        $em = $this->getDoctrine()->getEntityManager();


        /*Augmentation du stock pour chacun des produits à supprimer*/
        $orderlines = $em->getRepository("TBSBundle:Orderline")->findByBId($basket->getBId());

        foreach ($orderlines as $orderline) {
            
            $pid = $orderline->getPId();

            $product = $em->getRepository("TBSBundle:Product")->findOneByPId($pid);//Récupération du produit à supprimer

            $stock = $em->getRepository("TBSBundle:Stock")->findOneBySId($product->getSId());

            $new_stock = $stock->getSTotal() + ($orderline->getOlQtt() * $product->getPUnit());

            $stock->setSTotal($new_stock);

            $em->remove($orderline); //Supression du produit
            $em->persist($stock);
        }

        $em->remove($basket);   //Supression du panier
        $em->flush();

        return $this->redirect($this->generateUrl("tbs_index"));

     }

    /*Finalisation de la commande*/
    public function confirmAction(Basket $basket){


        $em = $this->getDoctrine()->getEntityManager();


        $basket->setBStatus('sent'); //Etat en cours de traitement
        $em->persist($basket);
        $em->flush();   


        return $this->redirect($this->generateUrl("tbs_index")); //Redirection vers la page d'acceuil

    }

    /*Confirmation de la réception de la commande*/
    public function doneAction(Basket $basket) {

        $em = $this->getDoctrine()->getEntityManager();


        $basket->setBStatus('done');//Etat commande bien livrée
        $em->persist($basket);
        $em->flush();   


        return $this->redirect($this->generateUrl("tbs_index"));//Redirection vers la page d'acceuil
    }

}