<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("fecha_inicio", "datetime",[
                'label' => 'Fecha y Hora de Inicio',
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add("fecha_fin", "datetime",[
                'label' => 'Fecha y Hora de Finalización',
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add("paciente", "choice",[
                'label' => 'Paciente',
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add("servicio", "choice",[
                'label' => 'Servicio',
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('paciente', 'entity', array(
                'class' => 'AppBundle:Paciente',
                'property'     => 'getNombreyApellido',
                'label' => 'Paciente',
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
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Reserva'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_reserva';
    }


}
