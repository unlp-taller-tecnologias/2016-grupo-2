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

    /** @ORM\Column(type="date") **/
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
     * @param integer $dni
     * @return Persona
     */
    public function setDni($dni)
    {
        $this->dni = $dni;
        return $this;
    }

    /**
     * Get dni
     *
     * @return integer
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
     * @param date $edad
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
     * @return date
     */
    public function getEdad()
    {
        return $this->edad;
    }

    /**
     * Get nombre y apellido
     *
     * @return string
     */
    public function getNombreyApellido()
    {
        $nombre = $this -> getNombre();
        $apellido = $this -> getApellido();
        return $nombre." ".$apellido;
    }

    /**
     * Get edadpersona
     *
     * @return integer
     */
    public function getEdadPersona()
    {
         $fechanac = $this->getEdad()->format('Y-m-d H:i:s');; //getEdad en realidad es el date que indica la fecha nacimiento 

        $fechaactual = (new \DateTime())->format('Y-m-d H:i:s');

        $edad = (strtotime($fechaactual)-strtotime($fechanac))/(365.25*60*60*24);
        $edad = abs($edad); $edad = floor($edad);

        
        return $edad;
        
    }




}
