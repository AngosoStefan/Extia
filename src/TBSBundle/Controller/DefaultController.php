<?php

namespace TBSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TBSBundle\Entity\User;
use TBSBundle\Entity\Basket;
use TBSBundle\Entity\Stock;
use TBSBundle\Entity\Location;

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

        $stocks = $em->getRepository("TBSBundle:Stock")->findAll();
        $baskets = $em->getRepository("TBSBundle:Basket")->findAll();

        $locations = $em->getRepository("TBSBundle:Location")->findAll();
        
        return $this->render('TBSBundle:Default:index.html.twig',array('orders'=>$orders,'stocks'=>$stocks,'baskets'=>$baskets,'locations'=>$locations));
    }

    public function indexcaAction(Basket $basket){
        $em = $this->getDoctrine()->getManager();
        
        $basket->setBStatus('ongoing');
        $em->persist($basket);
        $em->flush();
        //return $this->redirect($this->generateUrl("tbs_index"));
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

        return $this->redirect($this->generateUrl("tbs_homepage"));
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



}
