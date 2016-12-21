<?php
/**
 * Created by PhpStorm.
 * User: Fer
 * Date: 01/11/2016
 * Time: 19:43
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PersonalRepository")
 * @ORM\Table(name="personal")
 */
class Personal extends Persona
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;



    /**
     * @ORM\ManyToMany(targetEntity="Servicio",inversedBy="personal")
     * @ORM\JoinTable(name="personal_servicios")
     */
    protected $servicios;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Operacion", mappedBy="personal")
     *
     */
    protected $operaciones;

    /**
     * @ORM\ManyToOne(targetEntity="Rol")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    protected $rol;

    /** @ORM\Column(type="boolean") **/
    protected $baja=false;


    public function __construct() {
        $this->servicios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->operaciones = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set baja
     *
     * @param boolean $baja
     *
     * @return Personal
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
     * Add servicio
     *
     * @param \AppBundle\Entity\Servicio $servicio
     *
     * @return Personal
     */
    public function addServicio(\AppBundle\Entity\Servicio $servicio)
    {
        $this->servicios[] = $servicio;

        return $this;
    }

    /**
     * Remove servicio
     *
     * @param \AppBundle\Entity\Servicio $servicio
     */
    public function removeServicio(\AppBundle\Entity\Servicio $servicio)
    {
        $this->servicios->removeElement($servicio);
    }

    /**
     * Get servicios
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getServicios()
    {
        return $this->servicios;
    }

    /**
     * Add operacione
     *
     * @param \AppBundle\Entity\Operacion $operacione
     *
     * @return Personal
     */
    public function addOperacione(\AppBundle\Entity\Operacion $operacione)
    {
        $this->operaciones[] = $operacione;

        return $this;
    }

    /**
     * Remove operacione
     *
     * @param \AppBundle\Entity\Operacion $operacione
     */
    public function removeOperacione(\AppBundle\Entity\Operacion $operacione)
    {
        $this->operaciones->removeElement($operacione);
    }

    /**
     * Get operaciones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOperaciones()
    {
        return $this->operaciones;
    }

    /**
     * Set rol
     *
     * @param \AppBundle\Entity\Rol $rol
     *
     * @return Personal
     */
    public function setRol(\AppBundle\Entity\Rol $rol)
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * Get rol
     *
     * @return \AppBundle\Entity\Rol
     */
    public function getRol()
    {
        return $this->rol;
    }


    /**
     * Set rol
     *
     * @param \AppBundle\Entity\Personal $personal
     *
     * @return Personal
     */
    public function fillEntity(\AppBundle\Entity\Personal $personal){
        $this->setBaja($personal->getBaja());
        $this->setNombre($personal->getNombre());
        $this->setApellido($personal->getApellido());
        $this->setDni($personal->getDni());
        $this->setRol($personal->getRol());
        $this->setGenero($personal->getGenero());
        $this->setEdad($personal->getEdad());

        foreach ( $this->getServicios() as $servicio){
            $this->removeServicio($servicio);
        }
        foreach ( $personal->getServicios() as $servicio){
            $this->addServicio($servicio);
        }

        return $this;
    }
    
}
