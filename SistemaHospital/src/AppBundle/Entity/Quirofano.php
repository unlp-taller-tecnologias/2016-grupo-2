<?php
/**
 * Created by PhpStorm.
 * User: laquefer
 * Date: 01/11/16
 * Time: 09:49
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="quirofano")
 */
class Quirofano
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /** @ORM\Column(type="string", length=45) **/
    protected $nombre;

    /**
     * @ORM\OneToMany(targetEntity="Reserva", mappedBy="quirofano",cascade={"remove"}, orphanRemoval=true)
     */
    protected $reservas;

    public function __construct()
    {
        $this->reservas =  new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get Reservas
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getReservas()
    {
        return $this->reservas;
    }


    /**
     * Get id
     *
     * @ORM\return integer
     */
    public function getId()
    {
        return $this->id;
    }



    /**
     * Set nombre
     *
     * @ORM\param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Get nombre
     *
     * @ORM\return string
     */
    public function nombre()
    {
        return $this->nombre;
    }

  
}