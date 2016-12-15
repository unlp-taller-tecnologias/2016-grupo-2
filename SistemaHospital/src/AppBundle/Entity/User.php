<?php

namespace AppBundle\Entity;
use FOS\UserBundle\Model\User as BaseUser;
use AppBundle\Entity\Personal;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     *
     *
     *
     * @ORM\OneToOne(targetEntity="Personal",inversedBy="user")
     * @ORM\JoinColumn(name="personal_id", referencedColumnName="id", nullable=true)
     */
    private $personal;

    /** @ORM\Column(type="boolean") **/
    protected $baja=false;




    /* Es posible agregar más atributos además de los que vienen en BaseUser */
    public function __construct(){
        parent::__construct();
    }

    /**
     * Set Personal
     *
     * @param Personal $personal
     * @return User
     */
    public function setPersonal($personal)
    {
        $this->personal = $personal;
        return $this;
    }

    /**
     * Get personal
     *
     * @return Personal
     */
    public function getPersonal()
    {
        return $this->personal;
    }

    /**
     * Set baja
     *
     * @param boolean $baja
     *
     * @return User
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
}
