<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class PacienteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("nombre", "text",[
                'label' => 'Nombre *',
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add("apellido", "text",[
                'label' => 'Apellido *',
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add("dni", "integer",[
                'label' => 'DNI *',
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('edad', DateType::class, array(
                'widget' => 'single_text',
                 'label' => 'Fecha de nacimiento *',

                'format' => 'yyyy-MM-dd',
                 "attr" => [
                    "class" => " form-control"
                ]
            ))
            ->add("genero", "choice",[
                'label' => 'Género *',
                'choices' => [
                    'Masculino' => 'Masculino',
                    'Femenino' => 'Femenino'
                ],
                "attr" => [
                    "class" => "chosen-select form-control"
                ]
            ])
            ->add("mutual", "text",[
                'label' => 'Mutual',
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('baja', ChoiceType::class, array(
                'label' => 'Dar de baja',
                'choices'  => array(
                    1 => 'Si',
                    0 => 'No',
                ),
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
            'data_class' => 'AppBundle\Entity\Paciente'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_paciente';
    }


}
