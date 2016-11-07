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
 * @ORM\Table(name="paciente")
 */
class Paciente extends Persona 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /** @ORM\Column(type="string", length=45) **/
    protected $mutual;

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
     * Set mutual
     *
     * @ORM\param string $mutual
     */
    public function setMutual($mutual)
    {
        $this->mutual = $mutual;
    }

    /**
     * Get mutual
     *
     * @ORM\return string
     */
    public function getMutual()
    {
        return $this->mutual;
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