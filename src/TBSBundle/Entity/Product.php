<?php

namespace TBSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="TBSBundle\Repository\ProductRepository")
 */
class Product
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
     * @ORM\Column(name="p_id", type="integer", unique=true)
     */
    private $pId;

    /**
     * @var string
     *
     * @ORM\Column(name="p_name", type="string", length=25)
     */
    private $pName;

    /**
     * @var int
     *
     * @ORM\Column(name="p_unit", type="integer")
     */
    private $pUnit;

    /**
     * @var int
     *
     * @ORM\Column(name="s_id", type="integer")
     */
    private $sId;


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
     * Set pId
     *
     * @param integer $pId
     *
     * @return Product
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

    /**
     * Set pName
     *
     * @param string $pName
     *
     * @return Product
     */
    public function setPName($pName)
    {
        $this->pName = $pName;

        return $this;
    }

    /**
     * Get pName
     *
     * @return string
     */
    public function getPName()
    {
        return $this->pName;
    }

    /**
     * Set pUnit
     *
     * @param integer $pUnit
     *
     * @return Product
     */
    public function setPUnit($pUnit)
    {
        $this->pUnit = $pUnit;

        return $this;
    }

    /**
     * Get pUnit
     *
     * @return int
     */
    public function getPUnit()
    {
        return $this->pUnit;
    }

    /**
     * Set sId
     *
     * @param integer $sId
     *
     * @return Product
     */
    public function setSId($sId)
    {
        $this->sId = $sId;

        return $this;
    }

    /**
     * Get sId
     *
     * @return int
     */
    public function getSId()
    {
        return $this->sId;
    }
}

