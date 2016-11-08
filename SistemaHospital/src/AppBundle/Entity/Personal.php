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
 * @ORM\Entity
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
     * @ORM\OneToOne(targetEntity="User", mappedBy="personal")
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="Servicio",inversedBy="personal")
     * @ORM\JoinTable(name="personal_servicios")
     */
    protected $servicios;

    /**
     * @ORM\ManyToMany(targetEntity="Operacion",inversedBy="personal")
     * @ORM\JoinTable(name="personal_operacion")
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
     * Get $user
     *
     *@ORM\return User
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
     * @ORM\param \Doctrine\Common\Collections\ArrayCollection &servicios
     */
    public function setServicios($servicios)
    {
        $this->servicios = $servicios;
    }

    /**
     * Get Servicios
     *
     * @ORM\return \Doctrine\Common\Collections\ArrayCollection &servicios
     */
    public function getServicios()
    {
        return $this->servicios;
    }

    /**
     * Set Operaciones
     *
     * @ORM\param \Doctrine\Common\Collections\ArrayCollection $operaciones
     */
    public function setOperaciones($operaciones)
    {
        $this->operaciones = $operaciones;
    }

    /**
     * Get Operaciones
     *
     * @ORM\return \Doctrine\Common\Collections\ArrayCollection $operaciones
     */
    public function getOperaciones()
    {
        return $this->operaciones;
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
}