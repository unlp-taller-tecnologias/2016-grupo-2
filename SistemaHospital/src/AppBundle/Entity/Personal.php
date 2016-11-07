<?php
/**
 * Created by PhpStorm.
 * User: Fer
 * Date: 01/11/2016
 * Time: 19:43
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\User;
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
     * @ORM\ManyToOne(targetEntity="Rol")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    protected $rol;


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
}