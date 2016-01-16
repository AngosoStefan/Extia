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
        $sentorders = $em->getRepository("TBSBundle:Orderline")->findOrderlines();

        $stocks = $em->getRepository("TBSBundle:Stock")->findAll();
        
        return $this->render('TBSBundle:Default:index.html.twig',array('sentorders'=>$sentorders,'stocks'=>$stocks));
    }

    public function indexcaAction(Basket $basket){
        $em = $this->getDoctrine()->getManager();
        
        $basket->setBStatus('ongoing');
        $em->persist($basket);
        $em->flush();
        return $this->redirect($this->generateUrl("tbs_index"));
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
