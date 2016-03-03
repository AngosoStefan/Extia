<?php

namespace TBSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Orderline
 *
 * @ORM\Table(name="orderline")
 * @ORM\Entity(repositoryClass="TBSBundle\Repository\OrderlineRepository")
 */
class Orderline
{
    /**
     * @var int
     *
     * @ORM\Column(name="ol_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $olId;


    /**
     * @var int
     *
     * @ORM\Column(name="ol_qtt", type="integer")
     */
    private $olQtt;//Quantité souhaitée d'une boisson

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Basket")
     * @ORM\JoinColumn(name="b_id", referencedColumnName="b_id", onDelete="CASCADE")
     */
    private $bId;//Panier associé à la commande

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(name="p_id", referencedColumnName="p_id", nullable=false, onDelete="CASCADE")
     */
    private $pId;//Produit commandé



    /**
     * Set olQtt
     *
     * @param integer $olQtt
     *
     * @return Orderline
     */
    public function setOlQtt($olQtt)
    {
        $this->olQtt = $olQtt;

        return $this;
    }

    /**
     * Get olQtt
     *
     * @return int
     */
    public function getOlQtt()
    {
        return $this->olQtt;
    }

    
    /**
     * Get olId
     *
     * @return integer
     */
    public function getOlId()
    {
        return $this->olId;
    }

    /**
     * Set bId
     *
     * @param \TBSBundle\Entity\Basket $bId
     *
     * @return Orderline
     */
    public function setBId(\TBSBundle\Entity\Basket $bId = null)
    {
        $this->bId = $bId;

        return $this;
    }

    /**
     * Get bId
     *
     * @return \TBSBundle\Entity\Basket
     */
    public function getBId()
    {
        return $this->bId;
    }

    /**
     * Set pId
     *
     * @param \TBSBundle\Entity\Product $pId
     *
     * @return Orderline
     */
    public function setPId(\TBSBundle\Entity\Product $pId = null)
    {
        $this->pId = $pId;

        return $this;
    }

    /**
     * Get pId
     *
     * @return \TBSBundle\Entity\Product
     */
    public function getPId()
    {
        return $this->pId;
    }


}
