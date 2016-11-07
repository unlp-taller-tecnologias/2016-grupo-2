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
 * @ORM\Table(name="servicio")
 */
class Servicio
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
     * @ManyToMany(targetEntity="Personal", mappedBy="servicios")
     */
    protected $personal;


    public function __construct() {
        $this->personal = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set Descripcion
     *
     * @ORM\param string $descripcion
     */
    public function setDescripcion($tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * Get Descripcion
     *
     * @ORM\return string
     */
    public function getDescripcion()
    {
        return $this->tipo;
    }

    /**
     * Set Personal
     *
     * @ORM\param string $personal
     */
    public function setPersonal($personal)
    {
        $this->personal = $personal;
    }

    /**
     * Get Personal
     *
     * @ORM\return Personal
     */
    public function getPersonal()
    {
        return $this->personal;
    }
}