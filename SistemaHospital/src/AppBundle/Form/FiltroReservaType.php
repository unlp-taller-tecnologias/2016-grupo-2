<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
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
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.baja = FALSE');
                },
                'property'     => 'getTipo',
                "placeholder" =>"Elige un Servicio..",
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
                    "class" => "chosen-select form-control",
                ]
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Buscar Reservas',
                "attr" => [
                    "class" => "btn btn-primary col-md-offset-5"
                ]
            ));
    }

}
