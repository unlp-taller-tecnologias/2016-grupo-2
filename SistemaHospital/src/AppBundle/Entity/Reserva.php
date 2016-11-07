<?php
/**
 * Created by PhpStorm.
 * User: Fer
 * Date: 01/11/2016
 * Time: 17:03
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="reserva")
 */
class Reserva
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=45, unique=true) *
     */
    protected $numeroReserva;

    /** @ORM\Column(type="boolean") **/
    protected $baja=false;

    /** @Column(type="datetime") **/
    protected $fecha_inicio;

    /** @Column(type="datetime") **/
    protected $fecha_fin;


    public function __construct() {
        $this->servicios = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get $user
     *
     *@ORM\return integer
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set user
     *
     * @ORM\param User $user
     */
    public function setUser($user)
    {
        return $this->user=$user;
    }


    /**
     * Set Servicios
     *
     * @ORM\param string &servicios
     */
    public function setServicios($servicios)
    {
        $this->servicios = $servicios;
    }

    /**
     * Get Servicios
     *
     * @ORM\return Servicios
     */
    public function getServicios()
    {
        return $this->servicios;
    }

    /**
     * Set rol
     *
     * @param Rol $rol
     */
    public function setRol(Rol $rol)
    {
        $this->rol = $rol;
    }

    /**
     * Get rol
     *
     * @return Rol
     */
    public function getRol()
    {
        return $this->rol;
    }


    /**
     * Set Baja
     *
     * @ORM\param boolean
     */
    public function setBaja($baja)
    {
        $this->baja = $baja;
    }

    /**
     * Get Baja
     *
     * @ORM\return boolean
     */
    public function getBaja()
    {
        return $this->baja;
    }

    /**
     * Set fecha_inicio
     *
     * @ORM\param DateTime
     */
    public function setFechaInicio($fecha)
    {
        $this->fecha_inicio = $fecha;
    }

    /**
     * Get fecha_inicio
     *
     * @ORM\return DateTime
     */
    public function getFechaInicio()
    {
        return $this->fecha_inicio;
    }


    /**
     * Set fecha_fin
     *
     * @ORM\param DateTime
     */
    public function setFechaFin($fecha)
    {
        $this->fecha_fin = $fecha;
    }

    /**
     * Get fecha_fin
     *
     * @ORM\return DateTime
     */
    public function getFechaFin()
    {
        return $this->fecha_fin;
    }

}