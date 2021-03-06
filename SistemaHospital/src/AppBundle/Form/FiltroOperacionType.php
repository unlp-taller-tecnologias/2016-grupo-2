<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FiltroOperacionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("fechaIni", "text", [
                'label' => 'Filtrar reservas Desde',
                'required' => false,
                "attr" => [
                    "class" => "form-control datetimepicker",
                    "id" => "fechaIniOpe"
                ]
            ])
            ->add("fechaFin", "text", [
                'label' => 'Hasta',
                'required' => false,
                "attr" => [
                    "class" => "form-control datetimepicker",
                    "id" => "fechaFinOpe"
                ]
            ])
            ->add('servicios', 'entity', array(
                'multiple' => false,   // Multiple selection allowed
                'expanded' => false,   // Render as checkboxes
                'class' => 'AppBundle:Servicio',
                'property'     => 'getTipo',
                "placeholder" =>"Elige una Opción...",
                'required' => false,
                "attr" => [
                    "class" => " chosen-select form-control",

                ]
            ))
            ->add("numeroReserva", "text", [
                'label' => 'Número Reserva',
                'required' => false,
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('esInternado', ChoiceType::class, array(

                'label' =>false,
                "placeholder" =>"Elige una Opción...",
                "required" => false,
                'choices'  => array(
                    'Si' => "Si",
                    'No' => "No",
                ),
                'attr' => ['class' => 'chosen-select form-control']
            ))
            ->add('tq', ChoiceType::class, array(
                'label' =>false,
                "placeholder" =>"Elige una Opción...",
                "required" => false,
                'choices'  => array(
                    'Corta' => 'Corta',
                    'Media' => 'Media',
                    'Larga' => 'Larga',
                    'MuyLarga' => 'MuyLarga',
                ),
                'attr' => ['class' => 'chosen-select form-control']

            ))
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

            ->add('anestesia', 'entity', array(
                'multiple' => false,   // Multiple selection allowed
                'expanded' => false,   // Render as checkboxes
                'class' => 'AppBundle:Anestesia',
                'property'     => 'getTipo',
                "placeholder" =>"Elige una Opción...",
                'required' => false,
                "attr" => [
                    "class" => "chosen-select form-control",
                ]
            ))

            ->add('asa', 'entity', array(
                'label' => 'ASA',
                'multiple' => false,   // Multiple selection allowed
                'expanded' => false,   // Render as checkboxes
                'class' => 'AppBundle:Asa',
                'property'     => 'getGrado',
                "placeholder" =>"Elige una Opción...",
                'required' => false,
                "attr" => [
                    "class" => "form-control chosen-select",
                ]
            ))

//            ->add('personal', 'entity', array(
//                'multiple' => false,   // Multiple selection allowed
//                'expanded' => false,   // Render as checkboxes
//                'class' => 'AppBundle:Personal',
//                'property'    => 'getDni',
//                "placeholder" =>"Elige una opcion...",
//                'required' => false,
//                "attr" => [
//                    "class" => "form-control",
//                ]
//            ))

            ->add('save', SubmitType::class, array(
                'label' => 'Buscar Operación',
                "attr" => [
                    "class" => "btn btn-primary col-md-offset-5"
                ]
            ));
    }

}
