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

    /** @ORM\Column(type="datetime") **/
    protected $fecha_inicio;

    /** @ORM\Column(type="datetime") **/
    protected $fecha_fin;

    /**
     * @ORM\ManyToOne(targetEntity="Paciente",inversedBy="reservas")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $paciente;

    /**
     * @ORM\ManyToOne(targetEntity="Servicio",inversedBy="reservas")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $servicio;

    /**
     * @ORM\ManyToOne(targetEntity="Estado",inversedBy="reservas")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $estado;

    /**
     * @ORM\ManyToOne(targetEntity="Quirofano",inversedBy="reservas")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $quirofano;

    public function __construct() {

    }

    /**
     * Set Quirofano
     *
     * @ORM\param Quirofano $quirofano
     */
    public function setQuirofano($quirofano)
    {
        $this->quirofano = $quirofano;
    }

    /**
     * Get Quirofano
     *
     * @ORM\return Quirofano
     */
    public function getQuirofano()
    {
        return $this->quirofano;
    }

    /**
     * Set Estado
     *
     * @ORM\param Estado $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    /**
     * Get Estado
     *
     * @ORM\return Estado
     */
    public function getEstado()
    {
        return $this->servicio;
    }

    /**
     * Set Servicio
     *
     * @ORM\param Servicio $servicio
     */
    public function setServicio($servicio)
    {
        $this->servicio = $servicio;
    }

    /**
     * Get Servicio
     *
     * @ORM\return Servicio
     */
    public function getServicio()
    {
        return $this->servicio;
    }

    /**
     * Set Paciente
     *
     * @ORM\param Paciente $paciente
     */
    public function setPaciente($paciente)
    {
        $this->paciente = $paciente;
    }

    /**
     * Get Paciente
     *
     * @ORM\return Paciente
     */
    public function getPaciente()
    {
        return $this->paciente;
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