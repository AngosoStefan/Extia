<?php

namespace TBSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TBSBundle\Entity\User;
use TBSBundle\Entity\Basket;
use TBSBundle\Entity\Stock;


class DefaultController extends Controller
{
    /*Gestion de la page d'acceuil pour CA, admin et clients*/
    public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();//Récupération de l'utilisateur actuel

        if ($user == 'ca')
        {
            /* Ensemble des commandes reçues par le ca */
            $baskets = $em->getRepository("TBSBundle:Basket")->findBy(array('bStatus' => 'sent'), array('bId' => 'desc'));//Récupération des paniers en cours de traitement
            $orders = $em->getRepository("TBSBundle:Orderline")->findOrderlines();//Récupération des commandes

            /* Stocks à 0 */
            //$stocks = $em->getRepository("TBSBundle:Stock")->findBySTotal('0');
            $stocks = $em->getRepository("TBSBundle:Stock")->findAll();
            return $this->render('TBSBundle:Default:index.html.twig',array('orders'=>$orders,'stocks'=>$stocks,'baskets'=>$baskets));
        }
        elseif ($user == 'admin')
        {
            return $this->render('TBSBundle:Default:index.html.twig');
        }
        elseif ($user == 'anon.')
        {
            return $this->redirect($this->generateUrl("tbs_login"));//Redirection vers la page de login
        }
        else {
            /* Toutes les commandes d'un client*/
            $userBaskets = $em->getRepository("TBSBundle:Basket")->findBy(array('id' => $user->getId()));
            $orders = $em->getRepository("TBSBundle:Orderline")->findOrderlines();

            return $this->render('TBSBundle:Default:index.html.twig',array('orders'=>$orders,'userBaskets'=>$userBaskets));
        }

        
    }

    /*Validation de la commande par le CA*/
    public function indexcaAction($id){
        $em = $this->getDoctrine()->getManager();
        
        $basket = $em->getRepository("TBSBundle:Basket")->find($id);//Récupération d'un pannier en cours de traitement
        
        $basket->setBStatus('ongoing');//Passage de l'état en cours de livraison
        $em->persist($basket);
        $em->flush();
        return $this->redirect($this->generateUrl("tbs_index"));
        //return $this->render('TBSBundle:Default:simple.html.twig');
    }


    /*Affichage de tout les utilisateurs pour l'admin*/
    public function deleteAction(){
     	$em = $this->getDoctrine()->getManager();
     	$users = $em->getRepository("TBSBundle:User")->findAll();
     	return $this->render('TBSBundle:Default:delete.html.twig',array('users'=>$users));
    }


    /*Supression d'un utilisateur*/
    public function deleteUserAction(User $user){
        $em = $this->getDoctrine()->getManager();

        $em->remove($user);
        $em->flush();

        return $this->redirect($this->generateUrl("tbs_index"));
     }

     
    /*Gestion des statistiques*/
    public function statsAction() {

        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();//Récupération de l'utilisateur actuel

        $boissons = $em->getRepository("TBSBundle:Product")->findAll();

        $stat_array = array();
        //echo $user;

        /*Pour le CA afficher les statistiques sur l'ensemble des boissons consommés par les clients*/
        if($user== 'ca')
        {

            foreach ($boissons as $boisson) {

                $ols = $em->getRepository("TBSBundle:Orderline")->findByPId($boisson->getPId());
                $count = 0;
                foreach ($ols as $ol) {
                    $count = ($count) + ($ol->getOlQtt());
                }
                array_push($stat_array,array($boisson->getPName(),$count));//liste contenant les boissons consommées en total et leur quantité
            }

        }

        /*Pour le client afficher */
        if($user!= 'ca' && $user != 'admin')
        {
            $ols= $em->getRepository("TBSBundle:Orderline")->findOrderlinesbyId($user->getId());

            foreach ($boissons as $boisson) {

                $count = 0;

                foreach ($ols as $ol) {
                    if($ol->getPId() == $boisson->getPName())
                    {
                        $count = ($count) + ($ol->getOlQtt());
                    }
                    
                }
                array_push($stat_array,array($boisson->getPName(),$count));//liste contenant les boissons consommées par un client et leur quantité
            }

           

        }

        $nb_clients = $em->getRepository("TBSBundle:User")->countUsers();

        return $this->render('TBSBundle:Default:stats.html.twig',array('stat_array'=>$stat_array,'nb_clients'=>$nb_clients));//Envoie vers la page des statistiques
    }



    



}



