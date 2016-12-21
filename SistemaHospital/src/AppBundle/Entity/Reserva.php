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
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReservaRepository")
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

    /** @ORM\Column(type="boolean") **/
    protected $baja=false;

    /** @ORM\Column(type="datetime") **/
    protected $fecha_inicio;

    /** @ORM\Column(type="datetime") **/
    protected $fecha_fin;

    /**
     * @ORM\OneToOne(targetEntity="Operacion", inversedBy="reserva" )
     * @ORM\JoinColumn(name="operacion_id", referencedColumnName="id")
     */
    protected $operacion;

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

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }



    /**
     * Set baja
     *
     * @param boolean $baja
     *
     * @return Reserva
     */
    public function setBaja($baja)
    {
        $this->baja = $baja;

        return $this;
    }

    /**
     * Get baja
     *
     * @return boolean
     */
    public function getBaja()
    {
        return $this->baja;
    }

    /**
     * Set fechaInicio
     *
     * @param \DateTime $fechaInicio
     *
     * @return Reserva
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fecha_inicio = $fechaInicio;

        return $this;
    }

    /**
     * Get fechaInicio
     *
     * @return \DateTime
     */
    public function getFechaInicio()
    {
        return $this->fecha_inicio;
    }

    /**
     * Set fechaFin
     *
     * @param \DateTime $fechaFin
     *
     * @return Reserva
     */
    public function setFechaFin($fechaFin)
    {
        $this->fecha_fin = $fechaFin;

        return $this;
    }

    /**
     * Get fechaFin
     *
     * @return \DateTime
     */
    public function getFechaFin()
    {
        return $this->fecha_fin;
    }

    /**
     * Set operacion
     *
     * @param \AppBundle\Entity\Operacion $operacion
     *
     * @return Reserva
     */
    public function setOperacion(\AppBundle\Entity\Operacion $operacion = null)
    {
        $this->operacion = $operacion;

        return $this;
    }

    /**
     * Get operacion
     *
     * @return \AppBundle\Entity\Operacion
     */
    public function getOperacion()
    {
        return $this->operacion;
    }

    /**
     * Set paciente
     *
     * @param \AppBundle\Entity\Paciente $paciente
     *
     * @return Reserva
     */
    public function setPaciente(\AppBundle\Entity\Paciente $paciente)
    {
        $this->paciente = $paciente;

        return $this;
    }

    /**
     * Get paciente
     *
     * @return \AppBundle\Entity\Paciente
     */
    public function getPaciente()
    {
        return $this->paciente;
    }

    /**
     * Set servicio
     *
     * @param \AppBundle\Entity\Servicio $servicio
     *
     * @return Reserva
     */
    public function setServicio(\AppBundle\Entity\Servicio $servicio)
    {
        $this->servicio = $servicio;

        return $this;
    }

    /**
     * Get servicio
     *
     * @return \AppBundle\Entity\Servicio
     */
    public function getServicio()
    {
        return $this->servicio;
    }

    /**
     * Set estado
     *
     * @param \AppBundle\Entity\Estado $estado
     *
     * @return Reserva
     */
    public function setEstado(\AppBundle\Entity\Estado $estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return \AppBundle\Entity\Estado
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set quirofano
     *
     * @param \AppBundle\Entity\Quirofano $quirofano
     *
     * @return Reserva
     */
    public function setQuirofano(\AppBundle\Entity\Quirofano $quirofano = null)
    {
        $this->quirofano = $quirofano;

        return $this;
    }

    /**
     * Get quirofano
     *
     * @return \AppBundle\Entity\Quirofano
     */
    public function getQuirofano()
    {
        return $this->quirofano;
    }


    public function __toString() {
          return $this->numeroReserva;
    }
}
