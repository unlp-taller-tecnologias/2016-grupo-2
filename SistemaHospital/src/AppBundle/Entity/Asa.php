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
 * @ORM\Table(name="asa")
 */
class Asa
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /** @ORM\Column(type="string", length=45) **/
    protected $grado;

    /** @ORM\Column(type="string", length=255) **/
    protected $descripcion;

    /** @ORM\Column(type="boolean") **/

    protected $baja=false;

    /**
     * @ORM\OneToMany(targetEntity="Operacion", mappedBy="asa",cascade={"remove"}, orphanRemoval=true)
     */
    protected $operaciones;


    public function __construct()
    {
        $this->operaciones =  new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set grado
     *
     * @param string $grado
     *
     * @return Asa
     */
    public function setGrado($grado)
    {
        $this->grado = $grado;

        return $this;
    }

    /**
     * Get grado
     *
     * @return string
     */
    public function getGrado()
    {
        return $this->grado;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Asa
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set baja
     *
     * @param boolean $baja
     *
     * @return Asa
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
     * Add operacione
     *
     * @param \AppBundle\Entity\Operacion $operacione
     *
     * @return Asa
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
}
