<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;


class PersonalType extends AbstractType 
{

    public $em;

    public function __construct($entityManager) {
        $this->em = $entityManager;
    }
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("nombre", "text",[
                'label' => 'Nombre',
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add("apellido", "text",[
                'label' => 'Apellido',
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add("genero", "choice",[
                'label' => 'Género',
                'choices' => [
                    '' => '',
                    'Masculino' => 'Masculino',
                    'Femenino' => 'Femenino'
                ],
                "attr" => [
                    "class" => "chosen-select form-control"
                ]
            ])
            ->add("dni", "integer",[
                'label' => 'DNI',
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add("edad", "integer",[
                'label' => 'Edad',
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('servicios', 'entity', array(
                'multiple' => true,   // Multiple selection allowed
                'expanded' => false,   // Render as checkboxes
                'class' => 'AppBundle:Servicio',
                'property'     => 'getTipo',
                "attr" => [
                    "class" => "chosen-select form-control"
                ]
            ))
//            ->add('servicios', EntityType::class, [
//                'placeholder' => "Seleccione una opción..",
//                'class'=>"AppBundle:Servicio",
//                'choice_label' => 'getTipo',
//                "attr" => [
//                     "class" => "form-control"
//                 ]
//
//            ])
            ->add('rol', EntityType::class, [
                'empty_value' => '',
                'class'=>"AppBundle:Rol",
                'choice_label' => 'getNombre',
                "attr" => [
                    "class" => "chosen-select-rol form-control"
                ]
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Personal'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_personal';
    }


}
