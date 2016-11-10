<?php
/**
 * Created by PhpStorm.
 * User: Fer
 * Date: 07/11/2016
 * Time: 17:17
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="estado")
 */
class Estado
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /** @ORM\Column(type="string", length=45, unique=true) **/
    protected $tipo;

    /** @ORM\Column(type="string", length=255, nullable=true) **/
    protected $descripcion;

    /** @ORM\Column(type="boolean") **/
    protected $baja=false;


    /**
     * @ORM\OneToMany(targetEntity="Reserva", mappedBy="estado",cascade={"remove"}, orphanRemoval=true)
     */
    protected $reservas;

    public function __construct()
    {
        $this->reservas =  new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set id
     *
     * @ORM\param integer $id
     */
    public function getId()
    {
        return $this->id ;
    }

    /**
     * Set tipo
     *
     * @ORM\param string $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * Get tipo
     *
     * @ORM\return string
     */
    public function getTipo()
    {
        return $this->tipo;
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
     * Set tipo
     *
     * @ORM\param string $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->tipo = $descripcion;
    }

    /**
     * Get tipo
     *
     * @ORM\return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }
}