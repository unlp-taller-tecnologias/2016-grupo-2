<?php
/**
 * Created by PhpStorm.
 * User: Fer
 * Date: 01/11/2016
 * Time: 17:03
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 *
 * @ORM\MappedSuperclass
 */
class Persona
{
    /** @ORM\Column(type="string",length=50) **/
    protected $nombre;

    /** @ORM\Column(type="string",length=50) **/
    protected $apellido;

    /** @ORM\Column(type="string",length=50) **/
    protected $genero;

    /** @ORM\Column(type="integer", unique=true) **/
    protected $dni;

    /** @ORM\Column(type="integer") **/
    protected $edad;



    /**
     * Set nombre
     *
     * @ORM\param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Get nombre
     *
     * @ORM\return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellido
     *
     * @ORM\param string $apellido
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    }

    /**
     * Get apellido
     *
     * @ORM\return string
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set dni
     *
     * @ORM\param string $dni
     */
    public function setDni($dni)
    {
        $this->documento = $dni;
    }

    /**
     * Get dni
     *
     * @ORM\return string
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set genero
     *
     * @ORM\param string $genero
     */
    public function setGenero($genero)
    {
        $this->genero = $genero;
    }

    /**
     * Get genero
     *
     * @ORM\return string
     */
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * Set edad
     *
     * @ORM\param integer $edad
     */
    public function setEdad($edad)
    {
        $this->edad = $edad;
    }

    /**
     * Get edad
     *
     * @ORM\return integer
     */
    public function getEdad()
    {
        return $this->edad;
    }

}