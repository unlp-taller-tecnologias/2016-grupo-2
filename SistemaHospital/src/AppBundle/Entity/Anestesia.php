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
 * @ORM\Table(name="anestesia")
 */
class Anestesia
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /** @ORM\Column(type="string", length=45) **/
    protected $tipo;

    /** @ORM\Column(type="string", length=45) **/
    protected $descripcion;

    /** @ORM\Column(type="boolean") **/

    protected $baja=false;

    /**
     * @ORM\OneToMany(targetEntity="Operacion", mappedBy="anestesia",cascade={"remove"}, orphanRemoval=true)
     */
    protected $operaciones;

    public function __construct()
    {
        $this->operaciones =  new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get operaciones
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getOperaciones()
    {
        return $this->operaciones;
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
     * Set descripcion
     *
     * @ORM\param string $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * Get descripcion
     *
     * @ORM\return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }
}