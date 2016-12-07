<?php



namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
                'choice_label'  => function ($paciente) {
                    return (string)($paciente->getNombre()." ".$paciente->getApellido()." ".$paciente->getDni());
                },
                "placeholder" =>"Elige un Paciente...",
                'required' => false,
                "attr" => [
                    "class" => "chosen-select  form-control",
                ]
            ))
            /*->add('agregarpaciente', ButtonType::class, array(
                 'label' => 'Agregar un nuevo paciente',
                "attr" => [
                    "class" => "form-control"
                ]
            ))*/

            ->add('estado', 'entity', array(
                'class' => 'AppBundle:Estado',
                'property'     => 'getTipo',
                'label' => 'Estado de la reserva',
                "attr" => [
                    "class" => "form-control"
                ]
            ))
            
            ->add('servicio', 'entity', array(
                'class' => 'AppBundle:Servicio',
                'property'     => 'getTipo',
                'label' => 'Servicio',
                "attr" => [
                    "class" => "form-control"
                ]
            ))
            ->add('quirofano', 'entity', array(
                'class' => 'AppBundle:Quirofano',
                'property'     => 'getNombre',
                'label' => 'Quirófano',
                "attr" => [
                    "class" => "form-control"
                ]
            ))
            ->add('sangre', 'entity', array(
                'class' => 'AppBundle:Sangre',
                'property'     => 'getNombre',
                'label' => 'Sangre',
                "attr" => [
                    "class" => "form-control"
                ]
            ))
            ->add('asa', 'entity', array(
                'class' => 'AppBundle:Asa',
                'property'     => 'getGrado',
                'label' => 'Asa',
                "attr" => [
                    "class" => "form-control"
                ]
            ))
            ->add('Anestesia', 'entity', array(
                'class' => 'AppBundle:Anestesia',
                'property'     => 'getTipo',
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

}
