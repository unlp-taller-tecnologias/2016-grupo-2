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
     * @ORM\OneToOne(targetEntity="Personal", mappedBy="user")
     */
    private $personal;


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
}