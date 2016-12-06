<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FiltroReservaType extends AbstractType
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
                    "class" => "form-control datetimepicker"
                ]
            ])
            ->add("fechaFin", "text", [
                'label' => 'Hasta',
                'required' => false,
                "attr" => [
                    "class" => "form-control datetimepicker"
                ]
            ])
            ->add('servicios', 'entity', array(
                'multiple' => false,   // Multiple selection allowed
                'expanded' => false,   // Render as checkboxes
                'class' => 'AppBundle:Servicio',
                'property'     => 'getTipo',
                "placeholder" =>"Elige un servicio..",
                'required' => false,
                "attr" => [
                    "class" => "form-control",
                ]
            ))
            ->add("numeroReserva", "text", [
                'label' => 'Numero Reserva',
                'required' => false,
                "attr" => [
                    "class" => "form-control"
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
                    "class" => "form-control",
                ]
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Buscar reservas',
                "attr" => [
                    "class" => "btn btn-primary col-md-2 col-md-offset-5"
                ]
            ));
    }

}