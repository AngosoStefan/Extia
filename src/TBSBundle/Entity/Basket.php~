<?php

namespace TBSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Basket
 *
 * @ORM\Table(name="basket")
 * @ORM\Entity(repositoryClass="TBSBundle\Repository\BasketRepository")
 */
class Basket
{
    /**
     * @var int
     *
     * @ORM\Column(name="b_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $bId;



    /**
     * @var string
     *
     * @ORM\Column(name="b_floor", type="string", length=10)
     */
    private $bFloor;

    /**
     * @var int
     *
     * @ORM\Column(name="b_room", type="integer")
     */
    private $bRoom;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="b_date", type="datetime")
     */
    private $bDate;

    /**
     * @var string
     *
     * @ORM\Column(name="b_status", type="string", length=10)
     */
    private $bStatus;



    function __construct() {
        $this->bDate = new \DateTime();
    }
    

    /**
     * Set bFloor
     *
     * @param string $bFloor
     *
     * @return Basket
     */
    public function setBFloor($bFloor)
    {
        $this->bFloor = $bFloor;

        return $this;
    }

    /**
     * Get bFloor
     *
     * @return string
     */
    public function getBFloor()
    {
        return $this->bFloor;
    }

    /**
     * Set bDate
     *
     * @param \DateTime $bDate
     *
     * @return Basket
     */
    public function setBDate($bDate)
    {
        $this->bDate = $bDate;

        return $this;
    }

    /**
     * Get bDate
     *
     * @return \DateTime
     */
    public function getBDate()
    {
        return $this->bDate;
    }

    /**
     * Set bStatus
     *
     * @param string $bStatus
     *
     * @return Basket
     */
    public function setBStatus($bStatus)
    {
        $this->bStatus = $bStatus;

        return $this;
    }

    /**
     * Get bStatus
     *
     * @return string
     */
    public function getBStatus()
    {
        return $this->bStatus;
    }


    /**
     * Get bId
     *
     * @return integer
     */
    public function getBId()
    {
        return $this->bId;
    }

    /**
     * Set bRoom
     *
     * @param integer $bRoom
     *
     * @return Basket
     */
    public function setBRoom($bRoom)
    {
        $this->bRoom = $bRoom;

        return $this;
    }

    /**
     * Get bRoom
     *
     * @return integer
     */
    public function getBRoom()
    {
        return $this->bRoom;
    }

    /**
     * Set id
     *
     * @param \TBSBundle\Entity\User $id
     *
     * @return Basket
     */
    public function setId(\TBSBundle\Entity\User $id = null)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return \TBSBundle\Entity\User
     */
    public function getId()
    {
        return $this->id;
    }

    public function __toString()
    {
        return (string) $this->getBId();
    }
}
