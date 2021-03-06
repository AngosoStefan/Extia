<?php

namespace TBSBundle\Repository;

/**
 * OrderlineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OrderlineRepository extends \Doctrine\ORM\EntityRepository
{

    /* Renvoie toutes les lignes de commandes associées à un Basket sent */
	public function findOrderlines()
    {
        $query = $this->getEntityManager()
                        ->createQuery("
	            SELECT ol FROM TBSBundle:Orderline ol, TBSBundle:Basket b WHERE ol.bId = b.bId AND b.bStatus LIKE 'sent'"
                        );
        //$query->setParameter('b_id', $bId.'%');
        return $query->getResult();
    }

    /* Nombre de commandes associées à un bId*/
    public function countOrderlines($bId)
    {
        $query = $this->getEntityManager()
                        ->createQuery("
	            SELECT COUNT(ol) FROM TBSBundle:Orderline ol WHERE ol.bId = $bId"
                        );

        return $query->getSingleScalarResult();
    }

    /* Renvoie les lignes de commande associées à un Id */
    public function findOrderlinesbyId($Id)
    {
        $query = $this->getEntityManager()
                        ->createQuery("
                SELECT ol FROM TBSBundle:Orderline ol, TBSBundle:Basket b WHERE ol.bId = b.bId AND b.id = $Id"
                        );
        return $query->getResult();
    }

    

}
