<?php

namespace AppBundle\Entity;
use FOS\UserBundle\Model\User as BaseUser;

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
     * @ORM\OneToOne(targetEntity="Personal", inversedBy="user")
     * @ORM\JoinColumn(name="personal_id", referencedColumnName="id")
     */
    private $personal;


    /* Es posible agregar más atributos además de los que vienen en BaseUser */
    public function __construct(){
        parent::__construct();
    }

    /**
     * Set Personal
     *
     * @ORM\param Personal $personal
     */
    public function setPersonal($personal)
    {
        $this->personal = $personal;
    }

    /**
     * Get tipo
     *
     * @ORM\return string
     */
    public function getPersonal()
    {
        return $this->personal;
    }
}