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
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OperacionRepository")
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

    /** @ORM\Column(type="string", length=255,nullable=true) **/
    protected $cirujia;

    /** @ORM\Column(type="boolean") **/
    protected $internado=true;


    /** @ORM\Column(type="string", length=30) **/

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

    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->personal = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set diagnostico
     *
     * @param string $diagnostico
     *
     * @return Operacion
     */
    public function setDiagnostico($diagnostico)
    {
        $this->diagnostico = $diagnostico;

        return $this;
    }

    /**
     * Get diagnostico
     *
     * @return string
     */
    public function getDiagnostico()
    {
        return $this->diagnostico;
    }

    /**
     * Set habitacion
     *
     * @param string $habitacion
     *
     * @return Operacion
     */
    public function setHabitacion($habitacion)
    {
        $this->habitacion = $habitacion;

        return $this;
    }

    /**
     * Get habitacion
     *
     * @return string
     */
    public function getHabitacion()
    {
        return $this->habitacion;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return Operacion
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set internado
     *
     * @param boolean $internado
     *
     * @return Operacion
     */
    public function setInternado($internado)
    {
        $this->internado = $internado;

        return $this;
    }

    /**
     * Get internado
     *
     * @return boolean
     */
    public function getInternado()
    {
        return $this->internado;
    }


    /**
     * Set cirujia
     *
     * @param string $cirujia
     *
     * @return Operacion
     */
    public function setCirujia($cirujia)
    {
        $this->cirujia = $cirujia;
    }

    /**
     * Get Cirujia
     *
     * @return string
     */
    public function getCirujia()
    {
        return $this->diagnostico;
    }

    /**
     * Set tq
     *
     * @param integer $tq
     *
     * @return Operacion
     */
    public function setTq($tq)
    {
        $this->tq = $tq;

        return $this;
    }

    /**
     * Get tq
     *
     * @return integer
     */
    public function getTq()
    {
        return $this->tq;
    }

    /**
     * Set baja
     *
     * @param boolean $baja
     *
     * @return Operacion
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
     * Set sangre
     *
     * @param \AppBundle\Entity\Sangre $sangre
     *
     * @return Operacion
     */
    public function setSangre(\AppBundle\Entity\Sangre $sangre)
    {
        $this->sangre = $sangre;

        return $this;
    }

    /**
     * Get sangre
     *
     * @return \AppBundle\Entity\Sangre
     */
    public function getSangre()
    {
        return $this->sangre;
    }

    /**
     * Set asa
     *
     * @param \AppBundle\Entity\Asa $asa
     *
     * @return Operacion
     */
    public function setAsa(\AppBundle\Entity\Asa $asa)
    {
        $this->asa = $asa;

        return $this;
    }

    /**
     * Get asa
     *
     * @return \AppBundle\Entity\Asa
     */
    public function getAsa()
    {
        return $this->asa;
    }

    /**
     * Set anestesia
     *
     * @param \AppBundle\Entity\Anestesia $anestesia
     *
     * @return Operacion
     */
    public function setAnestesia(\AppBundle\Entity\Anestesia $anestesia)
    {
        $this->anestesia = $anestesia;

        return $this;
    }

    /**
     * Get anestesia
     *
     * @return \AppBundle\Entity\Anestesia
     */
    public function getAnestesia()
    {
        return $this->anestesia;
    }


    /**
     * Get reserva
     *
     * @return \AppBundle\Entity\Reserva

     */
    public function getReserva()
    {
        return $this->reserva;
    }

 /**
     * Add personal
     *
     * @param \AppBundle\Entity\Personal $personal
     *
     * @return Operacion
     */
    public function addPersonal(\AppBundle\Entity\Personal $personal)
    {
        $this->personal[] = $personal;

        return $this;
    }

     /**
     * Remove personal
     *
     * @param \AppBundle\Entity\Personal $personal
     */
    public function removePersonal(\AppBundle\Entity\Personal $personal)
    {
        $this->personal->removeElement($personal);
    }

    /**
     * Get personal
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPersonal()
    {
        return $this->personal;
    }

    /**
     * Set reserva
     *
     * @param \AppBundle\Entity\Reserva $reserva
     *
     * @return Operacion
     */

    public function setReserva(\AppBundle\Entity\Reserva $reserva = null)
    {
        $this->reserva = $reserva;

        return $this;
    }


}
