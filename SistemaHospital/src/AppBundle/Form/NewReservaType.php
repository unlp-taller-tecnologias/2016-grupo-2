<?php



namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\Estado;


class NewReservaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add("numero_reserva", "number",[
                'label' => 'Numero reserva',
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add("fecha_inicio", "text",[
                'label' => 'Fecha y Hora de Inicio',
                "attr" => [
                    "class" => "form-control datetimepicker"
                ]
            ])
            ->add("fecha_fin", "text",[
                'label' => 'Fecha y Hora de Finalización',
                "attr" => [
                    "class" => "form-control datetimepicker"
                ]
            ])
            ->add('paciente', 'entity', array(
                'multiple' => false,   // Multiple selection allowed
                'expanded' => false,   // Render as checkboxes
                'class' => 'AppBundle:Paciente',
                'property'     => 'getDni',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.baja = FALSE');
                },
                'choice_label'  => function ($paciente) {
                    return (string)($paciente->getNombre()." ".$paciente->getApellido()." ".$paciente->getDni());
                },
                "placeholder" =>"Elige un Paciente...",
                'required' => false,
                "attr" => [
                    "class" => "chosen-select  form-control",
                ]
            ))
           

            ->add('estado', 'entity', array(
                'class' => 'AppBundle:Estado',
                'property'     => 'getTipo',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.baja = FALSE');
                },
                'label' => 'Estado de la reserva',
                "attr" => [
                    "class" => "form-control"
                ]
            ))
            
            ->add('servicio', 'entity', array(
                'class' => 'AppBundle:Servicio',
                'property'     => 'getTipo',
                'label' => 'Servicio',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.baja = FALSE');
                },
                "attr" => [
                    "class" => "form-control"
                ]
            ))
            ->add('quirofano', 'entity', array(
                'class' => 'AppBundle:Quirofano',
                'property'     => 'getNombre',
                /*'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.baja = FALSE');
                },*/  //NO TIENE BAJA !!! NO SE QUE ONDA NOS HABREMOS OLVIDADO?
                'label' => 'Quirófano',
                "attr" => [
                    "class" => "form-control"
                ]
            ))
            ->add('sangre', 'entity', array(
                'class' => 'AppBundle:Sangre',
                'property'     => 'getNombre',
                /*'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.baja = FALSE');
                },*/ //NO TIENE BAJA !!! NO SE QUE ONDA NOS HABREMOS OLVIDADO?
                'label' => 'Sangre',
                "attr" => [
                    "class" => "form-control"
                ]
            ))
            ->add('asa', 'entity', array(
                'class' => 'AppBundle:Asa',
                'property'     => 'getGrado',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.baja = FALSE');
                },
                'label' => 'Asa',
                "attr" => [
                    "class" => "form-control"
                ]
            ))
            ->add('Anestesia', 'entity', array(
                'class' => 'AppBundle:Anestesia',
                'property'     => 'getTipo',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.baja = FALSE');
                },
                'label' => 'Anestesia',
                "attr" => [
                    "class" => "form-control"
                ]
            ))
            ->add("diagnostico", "text",[
                'label' => 'Diagnostico',
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add("habitacion", "text",[
                'label' => 'Habitacion',
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add("observaciones", "text",[
                'label' => 'Observaciones',
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add("cirugia", "text",[
                'label' => 'Cirugia',
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('Internado', ChoiceType::class, array(
                'choices'  => array(
                    1 => 'Si',
                    0 => 'No',
                ),
                "attr" => [
                    "class" => "form-control"
                ]
            ))
            ->add('TiempoQuirurgico', ChoiceType::class, array(
                'choices'  => array(
                    "Corto" => 'Corto',
                    "Medio" => 'Medio',
                    "Largo" => 'Largo',
                    "Muy Largo" => 'Muy Largo',
                ),
                "attr" => [
                    "class" => "form-control"
                ]
            ));
    }

     public function getEstados(){

        $resultado = array();
        $em = $this->getDoctrine()->getManager();
        $estados = $em->getRepository(Estado::class)->findAll();

        foreach ($estados as $e) {
            if ($e->getBaja() == 0) {
                array_push($resultado, $e);
            }
        }

        return $resultado;


    }

}
