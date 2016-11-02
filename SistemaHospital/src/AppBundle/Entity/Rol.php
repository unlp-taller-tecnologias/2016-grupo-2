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
 * @ORM\Table(name="rol")
 */
class Rol
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /** @ORM\Column(type="string", length=45) **/
    protected $nombre;

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
}