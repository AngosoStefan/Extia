<?php

namespace TBSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stock
 *
 * @ORM\Table(name="stock")
 * @ORM\Entity(repositoryClass="TBSBundle\Repository\StockRepository")
 */
class Stock
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
     * @ORM\Column(name="s_id", type="integer", unique=true)
     */
    private $sId;

    /**
     * @var string
     *
     * @ORM\Column(name="s_name", type="string", length=25)
     */
    private $sName;

    /**
     * @var int
     *
     * @ORM\Column(name="s_total", type="integer")
     */
    private $sTotal;


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
     * Set sId
     *
     * @param integer $sId
     *
     * @return Stock
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

    /**
     * Set sName
     *
     * @param string $sName
     *
     * @return Stock
     */
    public function setSName($sName)
    {
        $this->sName = $sName;

        return $this;
    }

    /**
     * Get sName
     *
     * @return string
     */
    public function getSName()
    {
        return $this->sName;
    }

    /**
     * Set sTotal
     *
     * @param integer $sTotal
     *
     * @return Stock
     */
    public function setSTotal($sTotal)
    {
        $this->sTotal = $sTotal;

        return $this;
    }

    /**
     * Get sTotal
     *
     * @return int
     */
    public function getSTotal()
    {
        return $this->sTotal;
    }
}

