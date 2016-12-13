<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Form\Type\DateTimePickerType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use AppBundle\Entity\Estado;
use Doctrine\ORM\EntityRepository;

use AppBundle\Entity\Sangre;

class ReservaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
             $builder
             ->add('fecha_inicio',  DateTimeType::class, array(
                
                'format' => 'yyyy-MM-dd',
                "attr" => [
                    "class" => " datetimepicker"
                ]
            ))
             ->add('fecha_fin',  DateTimeType::class, array(
                'format' => 'yyyy-MM-dd',
                "attr" => [
                    "class" => " datetimepicker"
                ]
            ))
            

           /*
           ->add("fecha_inicio", "date",[
                'label' => 'Fecha y Hora de Inicio *',
                
                "attr" => [
                    "class" => "form-control datetimepicker"
                ]
            ])

            ->add("fecha_fin", "date",[
                'label' => 'Fecha y Hora de Finalización *',
                
                "attr" => [
                    "class" => "form-control datetimepicker"
                ]
            ])
            */
            
            ->add("paciente", "choice",[
                'label' => 'Paciente',
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('estado', 'entity', array(
                'class' => 'AppBundle:Estado',
                'property'     => 'getTipo',
                'label' => 'Estado de la reserva',
                "attr" => [
                    "class" => "form-control"
                ]
            ))
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
            ))
            ;
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
