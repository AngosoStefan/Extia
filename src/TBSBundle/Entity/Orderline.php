<?php

namespace TBSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="ol_id", type="integer", unique=true)
     */
    private $olId;

    /**
     * @var string
     *
     * @ORM\Column(name="ol_product", type="string", length=20)
     */
    private $olProduct;

    /**
     * @var int
     *
     * @ORM\Column(name="ol_qtt", type="integer")
     */
    private $olQtt;

    /**
     * @var int
     *
     * @ORM\Column(name="b_id", type="integer")
     */
    private $bId;

    /**
     * @var int
     *
     * @ORM\Column(name="p_id", type="integer")
     */
    private $pId;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set olId
     *
     * @param integer $olId
     *
     * @return Orderline
     */
    public function setOlId($olId)
    {
        $this->olId = $olId;

        return $this;
    }

    /**
     * Get olId
     *
     * @return int
     */
    public function getOlId()
    {
        return $this->olId;
    }

    /**
     * Set olProduct
     *
     * @param string $olProduct
     *
     * @return Orderline
     */
    public function setOlProduct($olProduct)
    {
        $this->olProduct = $olProduct;

        return $this;
    }

    /**
     * Get olProduct
     *
     * @return string
     */
    public function getOlProduct()
    {
        return $this->olProduct;
    }

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
     * Set bId
     *
     * @param integer $bId
     *
     * @return Orderline
     */
    public function setBId($bId)
    {
        $this->bId = $bId;

        return $this;
    }

    /**
     * Get bId
     *
     * @return int
     */
    public function getBId()
    {
        return $this->bId;
    }

    /**
     * Set pId
     *
     * @param integer $pId
     *
     * @return Orderline
     */
    public function setPId($pId)
    {
        $this->pId = $pId;

        return $this;
    }

    /**
     * Get pId
     *
     * @return int
     */
    public function getPId()
    {
        return $this->pId;
    }
}

