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
 * @ORM\Table(name="operacion")
 */
class Operacion
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /** @ORM\Column(type="string", length=255) **/
    protected $diagnostico;

    /** @ORM\Column(type="string", length=30,nullable=true) **/
    protected $habitacion;

    /** @ORM\Column(type="string", length=255,nullable=true) **/
    protected $observaciones;

    /** @ORM\Column(type="boolean") **/
    protected $internado=true;

    /** @ORM\Column(type="integer") **/
    protected $tq;

    /** @ORM\Column(type="boolean") **/
    protected $baja=false;

    /**
     * @ORM\ManyToOne(targetEntity="Sangre",inversedBy="operaciones")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $sangre;

    /**
     * @ORM\ManyToOne(targetEntity="Asa",inversedBy="operaciones")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $asa;

    /**
     * @ORM\ManyToOne(targetEntity="Anestesia",inversedBy="operaciones")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $anestesia;

    /**
     * @ORM\OneToOne(targetEntity="Reserva", mappedBy="operacion")
     *
     */
    private $reserva;

    /**
     * @ORM\ManyToMany(targetEntity="Personal", mappedBy="operaciones")
     */
    protected $personal;

    public function __construct() {
        $this->personal = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get Reserva
     *
     * @ORM\return Reserva
     */
    public function getReserva()
    {
        return $this->reserva;
    }

    /**
     * Set Anestesia
     *
     * @ORM\param Anestesia $anestesia
     */
    public function setAnestesia($anestesia)
    {
        $this->anestesia = $anestesia;
    }

    /**
     * Get Anestesia
     *
     * @ORM\return Anestesia
     */
    public function getAnestesia()
    {
        return $this->anestesia;
    }

    /**
     * Set Asa
     *
     * @ORM\param Asa $asa
     */
    public function setAsa($asa)
    {
        $this->asa = $asa;
    }

    /**
     * Get Asa
     *
     * @ORM\return Asa
     */
    public function getAsa()
    {
        return $this->asa;
    }

    /**
     * Set Sangre
     *
     * @ORM\param Sangre $sangre
     */
    public function setSangre($sangre)
    {
        $this->sangre = $sangre;
    }

    /**
     * Get Sangre
     *
     * @ORM\return Sangre
     */
    public function getSangre()
    {
        return $this->sangre;
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
     * Set Diagnostico
     *
     * @ORM\param string $diagnostico
     */
    public function setDiagnostico($diagnostico)
    {
        $this->diagnostico = $diagnostico;
    }

    /**
     * Get Diagnostico
     *
     * @ORM\return string
     */
    public function getDiagnostico()
    {
        return $this->diagnostico;
    }

    /**
     * Set Habitacion
     *
     * @ORM\param string $habitacion
     */
    public function setHabitacion($habitacion)
    {
        $this->habitacion = $habitacion;
    }

    /**
     * Get Habitacion
     *
     * @ORM\return string
     */
    public function getHabitacion()
    {
        return $this->habitacion;
    }

    /**
     * Set baja
     *
     * @ORM\param $baja
     */
    public function setBaja($baja)
    {
        $this->baja = $baja;
    }

    /**
     * Get baja
     *
     * @ORM\return boolean
     *
     */
    public function getBaja()
    {
        return $this->baja;
    }

    /**
     * Set observaciones
     *
     * @ORM\param string $observaciones
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    }

    /**
     * Get observaciones
     *
     * @ORM\return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }


    /**
     * Set internado
     *
     * @ORM\param boolean $internado
     */
    public function setInternado($internado)
    {
        $this->internado = $internado;
    }

    /**
     * Get internado
     *
     * @ORM\return boolean
     *
     */
    public function getInternado()
    {
        return $this->internado;
    }


    /**
     * Get tq
     *
     * @ORM\return integer
     */
    public function getTq()
    {
        return $this->tq;
    }

    /**
     * Get tq
     *
     * @ORM\param string
     */
    public function setTq($tq)
    {
        $this->tq = $tq;
    }
}