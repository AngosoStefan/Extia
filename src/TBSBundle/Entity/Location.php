<?php

namespace TBSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Location
 *
 * @ORM\Table(name="location")
 * @ORM\Entity(repositoryClass="TBSBundle\Repository\LocationRepository")
 */
class Location
{
    /**
     * @var int
     *
     * @ORM\Column(name="l_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $lId;


    /**
     * @var string
     *
     * @ORM\Column(name="l_name", type="string", length=25)
     */
    private $lName;//Nom de la salle


    /**
     * @var int
     *
     * @ORM\Column(name="l_x", type="integer")
     */
    private $lX;//Position x de la salle


    /**
     * @var int
     *
     * @ORM\Column(name="l_y", type="integer")
     */
    private $lY;//Position y de la salle


    /**
     * Get lId
     *
     * @return integer
     */
    public function getLId()
    {
        return $this->lId;
    }

    /**
     * Set lName
     *
     * @param string $lName
     *
     * @return Location
     */
    public function setLName($lName)
    {
        $this->lName = $lName;

        return $this;
    }

    /**
     * Get lName
     *
     * @return string
     */
    public function getLName()
    {
        return $this->lName;
    }

    /**
     * Set lX
     *
     * @param integer $lX
     *
     * @return Location
     */
    public function setLX($lX)
    {
        $this->lX = $lX;

        return $this;
    }

    /**
     * Get lX
     *
     * @return integer
     */
    public function getLX()
    {
        return $this->lX;
    }

    /**
     * Set lY
     *
     * @param integer $lY
     *
     * @return Location
     */
    public function setLY($lY)
    {
        $this->lY = $lY;

        return $this;
    }

    /**
     * Get lY
     *
     * @return integer
     */
    public function getLY()
    {
        return $this->lY;
    }

    public function __toString()
    {
        return (string) $this->getLName();
    }
}
