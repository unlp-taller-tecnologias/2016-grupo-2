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
     * @param string $nombre
     * @return Persona
     *
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellido
     *
     * @param string $apellido
     *
     * @return Persona
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
        return $this;
    }

    /**
     * Get apellido
     *
     * @return string
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set dni
     *
     * @param string $dni
     * @return Persona
     */
    public function setDni($dni)
    {
        $this->documento = $dni;
        return $this;
    }

    /**
     * Get dni
     *
     * @return string
     * @return Persona
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set genero
     *
     * @param string $genero
     * @return Persona
     */
    public function setGenero($genero)
    {
        $this->genero = $genero;
        return $this;
    }

    /**
     * Get genero
     *
     * @return string
     *
     */
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * Set edad
     *
     * @param integer $edad
     * @return Persona
     */
    public function setEdad($edad)
    {
        $this->edad = $edad;
        return $this;
    }

    /**
     * Get edad
     *
     * @return integer
     */
    public function getEdad()
    {
        return $this->edad;
    }



}
