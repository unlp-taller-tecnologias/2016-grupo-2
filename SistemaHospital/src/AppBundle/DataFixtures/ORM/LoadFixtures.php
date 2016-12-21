<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Anestesia;
use AppBundle\Entity\Asa;
use AppBundle\Entity\Estado;
use AppBundle\Entity\Operacion;
use AppBundle\Entity\Paciente;
use AppBundle\Entity\Quirofano;
use AppBundle\Entity\Reserva;
use AppBundle\Entity\Rol;
use AppBundle\Entity\Sangre;
use AppBundle\Entity\Personal;
use AppBundle\Entity\Servicio;
use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Defines the sample data to load in the database when running the unit and
 * functional tests. Execute this command to load the data:
 *
 *   $ php bin/console doctrine:fixtures:load
 *
 * See http://symfony.com/doc/current/bundles/DoctrineFixturesBundle/index.html
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 */
class LoadFixtures extends AbstractFixture implements FixtureInterface, ContainerAwareInterface
{
    /** @var ContainerInterface */
    private $container;

    const ASASCANT = 5;
    const SANGRECANT = 8;
    const RESERVASYOPECANT = 1500;
    const ESTADOSCANT = 4;
    const QUIROFANOCANT = 5;
    const ANESTESIACANT = 5;
    const ROLESCANT = 5;
    const SERVICIOSCANT = 13;
    const PERSONALCANT = 30;
    const PACIENTESCANT = 500;
    const USERSCANT = 3;


    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->loadSangre($manager);
        $this->loadEstados($manager);
        $this->loadQuirofano($manager);
        $this->loadAsa($manager);
        $this->loadAnestesia($manager);
        $this->loadRoles($manager);
        $this->loadServicios($manager);
        $this->loadPersonals($manager);
        $this->loadPacientes($manager);
        $this->loadUsers($manager);

        //esta es la mas compleja de todas... tenemos que ver de que manera la hacemos
        $this->loadOperaciones($manager);
        $this->loadReservas($manager);
    }

    private function loadUsers(ObjectManager $manager)
    {
        $passwordEncoder = $this->container->get('security.password_encoder');

        $admin = new User();
        $admin->setEmail('admin@admin.com');
        $encodedPassword = $passwordEncoder->encodePassword($admin, '123456');
        $admin->setPassword($encodedPassword);
        $admin->setUsername("admin");
        $admin->addRole("ROLE_SUPER_ADMIN");
        $admin->setEnabled(true);
        $manager->persist($admin);

        $user1 = new User();
        $user1->setEmail('user1@user1.com');
        $encodedPassword = $passwordEncoder->encodePassword($user1, '123456');
        $user1->setPassword($encodedPassword);
        $user1->setUsername("user1");
        $user1->addRole("ROLE_ADMIN");
        $user1->setEnabled(true);
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail('user2@user2.com');
        $encodedPassword = $passwordEncoder->encodePassword($user2, '123456');
        $user2->setPassword($encodedPassword);
        $user2->setUsername("user2");
        $user2->addRole("ROLE_ADMIN");
        $user2->setEnabled(true);
        $manager->persist($user2);


        $manager->flush();
    }

    private function loadEstados(ObjectManager $manager)
    {

        $estado1 = new Estado();
        $estado1->setTipo("CANCELADA");
        $estado1->setDescripcion("Se cancela reservas antes de operar");
        $estado1->setBaja(0);
        $manager->persist($estado1);

        $estado2 = new Estado();
        $estado2->setTipo("FINALIZADA");
        $estado2->setDescripcion("Se finaliza reservas despues de operar");
        $estado2->setBaja(0);
        $manager->persist($estado2);

        $estado3 = new Estado();
        $estado3->setTipo("PENDIENTE");
        $estado3->setDescripcion("Se crea una nueva reservas espera operar");
        $estado3->setBaja(0);
        $manager->persist($estado3);

        $estado4 = new Estado();
        $estado4->setTipo("ESPERANDO CONFIRMACION");
        $estado4->setDescripcion("Una reserva se encuentra en operacion");
        $estado4->setBaja(0);
        $manager->persist($estado4);

        $manager->flush();
        $this->addReference('estado-1', $estado1);
        $this->addReference('estado-2', $estado2);
        $this->addReference('estado-3', $estado3);
        $this->addReference('estado-4', $estado4);

    }

    private function loadSangre(ObjectManager $manager)
    {
        // O- 	O+ 	A− 	A+ 	B− 	B+ 	AB− 	AB+

        $sangre1 = new Sangre();
        $sangre1->setNombre("A+");
        $manager->persist($sangre1);
        $sangre2 = new Sangre();
        $sangre2->setNombre("A-");
        $manager->persist($sangre2);
        $sangre3 = new Sangre();
        $sangre3->setNombre("0+");
        $manager->persist($sangre3);
        $sangre4 = new Sangre();
        $sangre4->setNombre("0-");
        $manager->persist($sangre4);
        $sangre5 = new Sangre();
        $sangre5->setNombre("B-");
        $manager->persist($sangre5);
        $sangre6 = new Sangre();
        $sangre6->setNombre("B+");
        $manager->persist($sangre6);
        $sangre7 = new Sangre();
        $sangre7->setNombre("AB+");
        $manager->persist($sangre7);
        $sangre8 = new Sangre();
        $sangre8->setNombre("AB-");
        $manager->persist($sangre8);

        $manager->flush();

        $this->addReference('sangre-1', $sangre1);
        $this->addReference('sangre-2', $sangre2);
        $this->addReference('sangre-3', $sangre3);
        $this->addReference('sangre-4', $sangre4);
        $this->addReference('sangre-5', $sangre5);
        $this->addReference('sangre-6', $sangre6);
        $this->addReference('sangre-7', $sangre7);
        $this->addReference('sangre-8', $sangre8);
    }

    private function loadQuirofano(ObjectManager $manager)
    {
        $quiro= array();
        foreach (range(1, self::QUIROFANOCANT) as $i) {
            $quiro[$i] = new Quirofano();
            $quiro[$i]->setNombre("Quirofano".$i);
            $manager->persist($quiro[$i]);
        }
        $manager->flush();
        foreach (range(1, self::QUIROFANOCANT) as $i) {
            $this->addReference('quirofano-'.$i, $quiro[$i]);
        }
    }

    private function loadAsa(ObjectManager $manager)
    {
        $asa= array();
        foreach (range(1, self::ASASCANT) as $i) {
            $asa[$i] = new Asa();
            $asa[$i]->setGrado("grado-".$i);
            $asa[$i]->setDescripcion("descripcion - ".$i);
            $manager->persist($asa[$i]);
        }
        $manager->flush();
        foreach (range(1, self::ASASCANT) as $i) {
            $this->addReference('asa-'.$i, $asa[$i]);
        }
    }

    private function loadAnestesia(ObjectManager $manager)
    {
        $anestesia= array();
        foreach (range(1, self::ANESTESIACANT) as $i) {
            $anestesia[$i] = new Anestesia();
            $anestesia[$i]->setTipo("tipo-".$i);
            $anestesia[$i]->setDescripcion("descripcion - ".$i);
            $manager->persist($anestesia[$i]);
        }
        $manager->flush();
        foreach (range(1, self::ANESTESIACANT) as $i) {
            $this->addReference('anestesia-'.$i, $anestesia[$i]);
        }
    }

    private function loadRoles(ObjectManager $manager)
    {

        $rol1 = new Rol();
        $rol1->setNombre("INSTRUMENTADOR");
        $rol1->setBaja(0);
        $manager->persist($rol1);

        $rol2 = new Rol();
        $rol2->setNombre("ENFERMERO");
        $rol2->setBaja(0);
        $manager->persist($rol2);

        $rol3 = new Rol();
        $rol3->setNombre("ANESTESIA");
        $rol3->setBaja(0);
        $manager->persist($rol3);

        $rol4 = new Rol();
        $rol4->setNombre("RESIDENTES");
        $rol4->setBaja(0);
        $manager->persist($rol4);

        $rol5 = new Rol();
        $rol5->setNombre("PLANTAS");
        $rol5->setBaja(0);
        $manager->persist($rol5);


        $manager->flush();

        $this->addReference('rol-1',$rol1);
        $this->addReference('rol-2',$rol2);
        $this->addReference('rol-3',$rol3);
        $this->addReference('rol-4',$rol4);
        $this->addReference('rol-5',$rol5);

    }

    private function loadServicios(ObjectManager $manager)
    {
        // O- 	O+ 	A− 	A+ 	B− 	B+ 	AB− AB+

        $serv1 = new Servicio();
        $serv1->setDescripcion("especialidad otorrinonaringologo");
        $serv1->setTipo("OTORRINONARINGOLOGIA");
        $serv1->setBaja(0);
        $manager->persist($serv1);


        $serv2 = new Servicio();
        $serv2->setDescripcion("especialidad oftalmologo");
        $serv2->setTipo("OFTALMOLOGIA");
        $serv2->setBaja(0);
        $manager->persist($serv2);

        $serv3 = new Servicio();
        $serv3->setDescripcion("especialidad neurologo");
        $serv3->setTipo("NEUROLOGIA");
        $serv3->setBaja(0);
        $manager->persist($serv3);

        $serv4 = new Servicio();
        $serv4->setDescripcion("especialidad gastroenterologo");
        $serv4->setTipo("GASTROENTEROLOGIA");
        $serv4->setBaja(0);
        $manager->persist($serv4);

        $serv5 = new Servicio();
        $serv5->setDescripcion("especialidad urologo");
        $serv5->setTipo("UROLOGIA");
        $serv5->setBaja(0);
        $manager->persist($serv5);

        $serv6 = new Servicio();
        $serv6->setDescripcion("especialidad ginecologo");
        $serv6->setTipo("GINECOLOGIA");
        $serv6->setBaja(0);
        $manager->persist($serv6);

        $serv7 = new Servicio();
        $serv7->setDescripcion("especialidad  cirujano cardiovascular");
        $serv7->setTipo("CIRUJIA CARDIOVASCULAR");
        $serv7->setBaja(0);
        $manager->persist($serv7);

        $serv8 = new Servicio();
        $serv8->setDescripcion("especialidad  traumatologo");
        $serv8->setTipo("TRAUMATOLOGIA");
        $serv8->setBaja(0);
        $manager->persist($serv8);

        $serv9 = new Servicio();
        $serv9->setDescripcion("especialidad  medico ortopedico");
        $serv9->setTipo("ORTOPEDIA");
        $serv9->setBaja(0);
        $manager->persist($serv9);

        $serv14 = new Servicio();
        $serv14->setDescripcion("especialidad  cirujano general");
        $serv14->setTipo("CIRUJIA GENERAL");
        $serv14->setBaja(0);
        $manager->persist($serv14);

        $serv10 = new Servicio();
        $serv10->setDescripcion("especialidad  cirujano plastico");
        $serv10->setTipo("CIRUJIA PLASTICA");
        $serv10->setBaja(0);
        $manager->persist($serv10);

        $serv11 = new Servicio();
        $serv11->setDescripcion("especialidad  ??");
        $serv11->setBaja(0);
        $serv11->setTipo("U.T.M.O");
        $manager->persist($serv11);

        $serv12 = new Servicio();
        $serv12->setDescripcion("especialidad  anestesista");
        $serv12->setTipo("ANESTESIOLOGIA");
        $serv12->setBaja(0);
        $manager->persist($serv12);

        $serv13 = new Servicio();
        $serv13->setDescripcion("especialidad  cardiologo");
        $serv13->setTipo("CARDIOLOGIA");
        $serv13->setBaja(0);
        $manager->persist($serv13);

        $manager->flush();

        $this->addReference('servicio-13',$serv13);$this->addReference('servicio-11',$serv11);$this->addReference('servicio-12',$serv12);
        $this->addReference('servicio-10',$serv10);$this->addReference('servicio-9',$serv9);$this->addReference('servicio-8',$serv8);
        $this->addReference('servicio-7',$serv7);$this->addReference('servicio-6',$serv6);$this->addReference('servicio-5',$serv5);
        $this->addReference('servicio-4',$serv4);$this->addReference('servicio-3',$serv3);$this->addReference('servicio-2',$serv2);
        $this->addReference('servicio-1',$serv1);
    }



    private function loadPacientes(ObjectManager $manager)
    {
        $min=10000000;
        $max=99999999;
      

        $fecha=new \DateTime('02/31/1990');
        $paciente= array();
        $mutual=["OSECAC","IOMA","IPROSS","UPCN","AMEP","MAPEDUC","OSPE","AMTE"];
        foreach (range(1, self::PACIENTESCANT) as $i) {
            $paciente[$i] = new Paciente();
            $paciente[$i]->setNombre($this->getRandomNombre());
            $paciente[$i]->setApellido($this->getRandomApellido());
            $paciente[$i]->setBaja(0);
            $paciente[$i]->setDni(rand ( $min , $max ));
            $paciente[$i]->setEdad($fecha);
            $paciente[$i]->setMutual($mutual[array_rand($mutual)]);
            $paciente[$i]->setGenero("Masculino");
            $manager->persist($paciente[$i]);
        }
        $manager->flush();
        foreach (range(1, self::PACIENTESCANT) as $i) {
            $this->addReference('paciente-'.$i, $paciente[$i]);
        }
    }

    function randomDate($start_date, $end_date)
    {
        // Convert to timetamps
        $min = strtotime($start_date);
        $max = strtotime($end_date);

        // Generate random number using above bounds
        $val = rand($min, $max);

        // Convert back to desired date format
        return date('Y-m-d H:i:s', $val);
    }

    private function loadReservas(ObjectManager $manager)
    {
        $reservas=array();
        $value = 0001;
        $randDays=["+1","-1","+0","+2","-2","-3","+3","+4","-4","+5","-5"];
        foreach (range(1, self::RESERVASYOPECANT) as $i) {
            $reservas[$i] = new Reserva();
            $operaciones[$i]=new Operacion();


            $rand=$randDays[array_rand($randDays)];

            $reservas[$i]->setFechaInicio(new \DateTime('now '.$rand.'days'));
            $reservas[$i]->setFechaFin(new \DateTime('now '.$rand.'days'));

            $rand= rand(1,self::PACIENTESCANT);
            $reservas[$i]->setPaciente($this->getReference("paciente-$rand"));
            $rand= rand(1,self::SERVICIOSCANT);
            $reservas[$i]->setServicio($this->getReference("servicio-$rand"));
            $rand= rand(1,self::ESTADOSCANT);
            $reservas[$i]->setEstado($this->getReference("estado-$rand"));
            $rand= rand(1,self::QUIROFANOCANT);
            $reservas[$i]->setQuirofano($this->getReference("quirofano-$rand"));
            $reservas[$i]->setOperacion($this->getReference("operacion-$i"));
            $manager->persist($reservas[$i]);
            $value++;
        }
        $manager->flush();
    }

    private function loadPersonals(ObjectManager $manager)
    {
        $min=10000000;
        $max=99999999;
        $fecha=new \DateTime('02/31/1990');
        $personal= array();
        foreach (range(1, self::PERSONALCANT) as $i) {
            $personal[$i] = new Personal();
            $randRol=rand( 1 , self::ROLESCANT );//valores random para aplicar roles y servicios
            $personal[$i]->setNombre($this->getRandomNombre());
            $personal[$i]->setApellido($this->getRandomApellido());
            $personal[$i]->setBaja(0);
            $personal[$i]->setDni(rand ( $min , $max ));
            $personal[$i]->setEdad($fecha);
            $personal[$i]->setRol($this->getReference("rol-$randRol"));
            $randServ=array(1,2,3,4,5,6,7,8,9,10,11,12,13);
            foreach (range(1, 4) as $j) {
                $ran = $randServ[array_rand($randServ)];
                $personal[$i]->addServicio($this->getReference("servicio-$ran"));
                unset($randServ[$ran-1]);
            }
            $personal[$i]->setGenero("Masculino");

            //$personal->setPublishedAt(new \DateTime('now - '.$i.'days'));

            $manager->persist($personal[$i]);
        }

        $manager->flush();

        foreach (range(1, self::PERSONALCANT) as $i) {
            $this->addReference('personal-'.$i, $personal[$i]);
        }
    }


    private function loadOperaciones(ObjectManager $manager)
    {

        $operaciones=array();

        $obs=["Electro RX","Electro","Electro"];//dos veces electro para que haganm  mas chances de q toq
        $hab=["328v","250c","110g","110a","110b","110c", "210a"];
        $tq=["Corta","Media","Larga","MuyLarga"];
        /* de 0 a 2 hrs ->corta
            de 2 a 3 hrs -> media
            de 3 a 4 hrs -> larga
            de 4 o > ->muy largo
         * */
        foreach (range(1, self::RESERVASYOPECANT) as $i) {
            $operaciones[$i]=new Operacion();
            $operaciones[$i]->setDiagnostico($this->getRandomFrase());
            $operaciones[$i]->setObservaciones($obs[array_rand($obs)]);
            $operaciones[$i]->setHabitacion($hab[array_rand($hab)]);
            $operaciones[$i]->setCirujia($this->getRandomFrase());
            $operaciones[$i]->setTq($tq[array_rand($tq)]);
            $rand= rand(1,self::ANESTESIACANT);
            $operaciones[$i]->setAnestesia($this->getReference("anestesia-$rand"));
            $rand= rand(1,self::ASASCANT);
            $operaciones[$i]->setAsa($this->getReference("asa-$rand"));
            $rand= rand(1,self::SANGRECANT);
            $operaciones[$i]->setSangre($this->getReference("sangre-$rand"));

            $randPersonal=array();
            foreach (range(1,self::PERSONALCANT) as $j) {
                $randPersonal[] = $j;
            }
            foreach (range(1, 4) as $j) {
                $ran = $randPersonal[array_rand($randPersonal)];
                $operaciones[$i]->addPersonal($this->getReference("personal-$ran"));
                unset($randPersonal[$ran-1]);
            }
            //falta reserva
            $manager->persist($operaciones[$i]);
        }
        $manager->flush();
        foreach (range(1, self::RESERVASYOPECANT) as $i) {
            $this->addReference('operacion-'.$i, $operaciones[$i]);
        }
    }


    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }


    private function getNombres()
    {
        return [
            "Aaron","Aaronit","Aba","Abaco","Abalen","Abbas","Abbie","Abbott",
            "Abdala","Abdas","Abdel","Abdias","Abdieso","Abdo","Abdon","Abdul","Abe","Abel","Abelardo","Abenamar",
            "Abencio","Abeni","Aberardo","Abercio","Abey","Abhay","Abi","Abia","Abibo","Abibon",
            "Abiel","Abigail","Abilio","Abira","Abisai","Abner","Abra","Gerardo","Pablo","Matias","Martin","Santiago",
            "Ramiro","Lucas","Alejo","Fernando","Mario","Roberto","Pepe","Juan","Pablo","Marcos","Alejandro",
            "Federico","Agustin","Rodolfo","Simon","Stefano","Ignacio",
            "Andres","Gonzalo"
        ];
    }

    private function getApellidos()
    {
        return [
            "Gonzales","Rodriguez","Lopez","Fernandez","Garcia","Perez","Martinez","Gomez",
            "Dias","Sanchez","Alvarez","Romero","Sosa","Ruiz","Torres","Suarez",
            "Castro","Gimenez","Vazquez","Acosta","Gutierrez","Pereyra","Ramirez","Flores","Benitez",
            "Aguirre","Molina","Ortiz","Medina","Herrera","Dominguez","Martin","Moreno","Rojas","Blanco",
            "Quiroga","Cabrera","Ferreyra","Peralta","Alonso","Silva","Morales","Luna","Mendez","Ramos",
            "Rios",
        ];
    }

    private function getPhrases()
    {
        return [
            'Lorem ipsum dolor sit amet consectetur adipiscing elit',
            'Pellentesque vitae velit ex',
            'Mauris dapibus risus quis suscipit vulputate',
            'Eros diam egestas libero eu vulputate risus',
            'In hac habitasse platea dictumst',
            'Morbi tempus commodo mattis',
            'Ut suscipit posuere justo at vulputate',
            'Ut eleifend mauris et risus ultrices egestas',
            'Aliquam sodales odio id eleifend tristique',
            'Urna nisl sollicitudin id varius orci quam id turpis',
            'Nulla porta lobortis ligula vel egestas',
            'Curabitur aliquam euismod dolor non ornare',
            'Sed varius a risus eget aliquam',
            'Nunc viverra elit ac laoreet suscipit',
            'Pellentesque et sapien pulvinar consectetur',
        ];
    }

    private function getRandomFrase()
    {
        $phrases = $this->getPhrases();

        $numPhrases = mt_rand(2, 15);
        shuffle($phrases);

        return implode(' ', array_slice($phrases, 0, $numPhrases-1));
    }

    private function getRandomNombre()
    {
        $titles = $this->getNombres();

        return $titles[array_rand($titles)];
    }

    private function getRandomApellido()
    {
        $titles = $this->getApellidos();

        return $titles[array_rand($titles)];
    }
}
