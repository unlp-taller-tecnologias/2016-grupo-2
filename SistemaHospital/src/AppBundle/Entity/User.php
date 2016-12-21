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


    /** @ORM\Column(type="boolean") **/
    protected $baja=false;


    /* Es posible agregar más atributos además de los que vienen en BaseUser */
    public function __construct(){
        parent::__construct();
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
