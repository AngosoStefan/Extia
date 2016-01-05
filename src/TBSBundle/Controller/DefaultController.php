<?php

namespace TBSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TBSBundle\Entity\User;

class DefaultController extends Controller
{
    public function indexAction(){
    	$em = $this->getDoctrine()->getEntityManager();
        return $this->render('TBSBundle:Default:index.html.twig');
    }

     public function deleteAction(){
     	$em = $this->getDoctrine()->getEntityManager();
     	$users = $em->getRepository("TBSBundle:User")->findAll();
     	return $this->render('TBSBundle:Default:delete.html.twig',array('users'=>$users));
     }

    public function deleteUserAction(User $user){
        $em = $this->getDoctrine()->getEntityManager();

        $em->remove($user);
        $em->flush();

        return $this->redirect($this->generateUrl("tbs_homepage"));
     }

     public function editUserAction(User $user){
        $em = $this->getDoctrine()->getEntityManager();
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
