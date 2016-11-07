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
class Personal extends  Persona
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @OneToOne(targetEntity="User", mappedBy="Personal")
     * @JoinColumn(nullable=false)
     */
    protected $user;

    /**
     * @ManyToMany(targetEntity="Servicio",inversedBy="personal")
     * @JoinTable(name="personal_servicios")
     */
    protected $servicios;


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
}