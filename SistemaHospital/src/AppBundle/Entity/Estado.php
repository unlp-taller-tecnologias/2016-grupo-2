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
 * @ORM\Table(name="estado")
 */
class Estado
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
     * @ORM\OneToMany(targetEntity="Reserva", mappedBy="estado",cascade={"remove"}, orphanRemoval=true)
     */
    protected $reservas;

    public function __construct()
    {
        $this->reservas =  new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set tipo
     *
     * @param string $tipo
     *
     * @return Estado
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Estado
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
     * @return Estado
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
     * Add reserva
     *
     * @param \AppBundle\Entity\Reserva $reserva
     *
     * @return Estado
     */
    public function addReserva(\AppBundle\Entity\Reserva $reserva)
    {
        $this->reservas[] = $reserva;

        return $this;
    }

    /**
     * Remove reserva
     *
     * @param \AppBundle\Entity\Reserva $reserva
     */
    public function removeReserva(\AppBundle\Entity\Reserva $reserva)
    {
        $this->reservas->removeElement($reserva);
    }

    /**
     * Get reservas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReservas()
    {
        return $this->reservas;
    }
     public function __toString() {
          return $this->tipo;
    }
}
