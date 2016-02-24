<?php

namespace TBSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TBSBundle\Entity\User;
use TBSBundle\Entity\Basket;
use TBSBundle\Entity\Stock;

class DefaultController extends Controller
{
    public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if($user== 'anon.')
        {
            return $this->redirect($this->generateUrl("tbs_login"));
        }
        $orders = $em->getRepository("TBSBundle:Orderline")->findOrderlines();

        $stocks = $em->getRepository("TBSBundle:Stock")->findBySTotal('0');
        $baskets = $em->getRepository("TBSBundle:Basket")->findBy(array('bStatus' => 'sent'), array('bId' => 'desc'));

        return $this->render('TBSBundle:Default:index.html.twig',array('orders'=>$orders,'stocks'=>$stocks,'baskets'=>$baskets));
    }

    public function indexcaAction($id){
        $em = $this->getDoctrine()->getManager();
        
        $basket = $em->getRepository("TBSBundle:Basket")->find($id);
        
        $basket->setBStatus('ongoing');
        $em->persist($basket);
        $em->flush();
        return $this->redirect($this->generateUrl("tbs_index"));
        //return $this->render('TBSBundle:Default:simple.html.twig');
    }

    public function rosAction(){
        
        return $this->render('TBSBundle:Default:simple.html.twig');
    }

     public function deleteAction(){
     	$em = $this->getDoctrine()->getManager();
     	$users = $em->getRepository("TBSBundle:User")->findAll();
     	return $this->render('TBSBundle:Default:delete.html.twig',array('users'=>$users));
     }

    public function deleteUserAction(User $user){
        $em = $this->getDoctrine()->getManager();

        $em->remove($user);
        $em->flush();

        return $this->redirect($this->generateUrl("tbs_index"));
     }

     public function editUserAction(User $user){
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new UserType(), $user);
        $request = $this->getRequest();
        if($request->isMethod('POST')){
            $form->bind($request);
            //$a->upload();
            if($form->isValid())
            {
                $c = $form->getData();
                $em->persist($c);
                $em->flush();
                return $this->redirect($this->generateUrl("abs_blog_show_celebrity",array('name' => $c->getName(),)));
            }   
        }
        return $this->render('ABSBlogBundle:Celebrity:edit.html.twig',array('form'=> $form->createView(), 'celebrity'=> $celebrity,));
    }


    public function statsAction() {

        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $boissons = $em->getRepository("TBSBundle:Product")->findAll();

        $stat_array = array();
        //echo $user;
        if($user== 'ca')
        {

            foreach ($boissons as $boisson) {

                $ols = $em->getRepository("TBSBundle:Orderline")->findByPId($boisson->getPId());
                $count = 0;
                foreach ($ols as $ol) {
                    $count = ($count) + ($ol->getOlQtt());
                }
                array_push($stat_array,array($boisson->getPName(),$count));
            }

        }




        if($user!= 'ca' && $user != 'admin')
        {
            echo $user;
            $ols= $em->getRepository("TBSBundle:Orderline")->findOrderlinesbyId($user->getId());

            foreach ($boissons as $boisson) {

                $count = 0;

                foreach ($ols as $ol) {
                    if($ol->getPId() == $boisson->getPName())
                    {
                        $count = ($count) + ($ol->getOlQtt());
                    }
                    
                }
                array_push($stat_array,array($boisson->getPName(),$count));
            }

           

        }

        $nb_clients = $em->getRepository("TBSBundle:User")->countUsers();


        return $this->render('TBSBundle:Default:stats.html.twig',array('stat_array'=>$stat_array,'nb_clients'=>$nb_clients));
    }


    



}



