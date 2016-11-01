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
 * @Entity
 * @Table(name="rol")
 */
class Rol
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /** @Column(type="string", length=45) **/
    protected $nombre;

    /** @Column(type="boolean") **/
    protected $baja=false;

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
     * Set nombre
     *
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
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
     * Set baja
     *
     * @param $baja
     */
    public function setBaja($baja)
    {
        $this->baja = $baja;
    }

    /**
     * Get baja
     *
     * @return boolean
     *
     */
    public function getBaja()
    {
        return $this->baja;
    }
}