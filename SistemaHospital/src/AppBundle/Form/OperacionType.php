<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class OperacionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("diagnostico", "text",[
                'label' => 'Diagnóstico',
                "attr" => [
                    "class" => "form-control"
                ]
            ])
       ->add("habitacion", "text",[
                'label' => 'Habitación',
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
        ->add("cirujia", "text",[
                'label' => 'Cirugía',
                "attr" => [
                    "class" => "form-control"
                ]
            ])
        ->add('internado', ChoiceType::class, array(
                'choices'  => array(
                    1 => 'Si',
                    0 => 'No',
                ),
                "attr" => [
                    "class" => "form-control"
                ]
            ))
        ->add('tq', ChoiceType::class, array(
                'choices'  => array(
                    "Corto" => 'Corto',
                    "Medio" => 'Medio',
                    "Largo" => 'Largo',
                    "Muy Largo" => 'Muy Largo',
                ),
                "attr" => [
                    "class" => "form-control"
                ]
            ))
        ->add('baja', ChoiceType::class, array(
                'label' => 'Dar de baja',
                'choices'  => array(
                    1 => 'Si',
                    0 => 'No',
                ),
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
        ->add('anestesia', 'entity', array(
                'multiple' => false,   // Multiple selection allowed
                'expanded' => false,   // Render as checkboxes
                'class' => 'AppBundle:anestesia',
                'property'     => 'getTipo',
                "attr" => [
                    "class" => "form-control"
                ]
            ))
        
        ->add('personal', 'entity', array(
                'multiple' => true,   // Multiple selection allowed
                'expanded' => false,   // Render as checkboxes
                'class' => 'AppBundle:Personal',
                'choice_label'  => function ($personal) {
                    return (string)($personal->getNombre()." ".$personal->getApellido()." ".$personal->getDni());
                },
                "placeholder" =>"Elige uno o varios personales...",
                'required' => false,
                "attr" => [
                    "class" => "chosen-select  form-control",
                ]
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Operacion'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_operacion';
    }


}
