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
     * Get id
     *
     * @ORM\return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set grado
     *
     * @ORM\param string $grado
     */
    public function setGrado($grado)
    {
        $this->grado = $grado;
    }

    /**
     * Get grado
     *
     * @ORM\return string
     */
    public function getGrado()
    {
        return $this->grado;
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