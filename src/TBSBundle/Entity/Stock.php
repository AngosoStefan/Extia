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
     * @ORM\Column(name="s_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $sId;

    

    /**
     * @var string
     *
     * @ORM\Column(name="s_name", type="string", length=25)
     */
    private $sName;//Nom du stock

    /**
     * @var int
     *
     * @ORM\Column(name="s_total", type="integer")
     */
    private $sTotal;//Stock total


    

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

    /**
     * Get sId
     *
     * @return integer
     */
    public function getSId()
    {
        return $this->sId;
    }

    public function __toString()
    {
        return (string) $this->getSName();
    }
}
