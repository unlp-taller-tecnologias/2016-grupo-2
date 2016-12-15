<?php

namespace AppBundle\Form;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use AppBundle\Form\Type\DateTimePickerType;
use Doctrine\ORM\EntityRepository;


class PersonalType extends AbstractType 
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        try{
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
            ->add("genero", "choice",[
                'label' => 'Género *',
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
                'label' => 'DNI *',
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('edad',  DateTimePickerType::class, array(
                'format' => 'yyyy-MM-dd',
                'label' => 'Fecha de nacimiento *',
                "attr" => [
                    "class" => "form-control datetimepicker"
                ]
            ))

            ->add('servicios', 'entity', array(
                'label' => 'Servicios *',
                'multiple' => true,   // Multiple selection allowed
                'expanded' => false,   // Render as checkboxes
                'class' => 'AppBundle:Servicio',
                'property'     => 'getTipo',
                'query_builder' => function (EntityRepository $er){
                    return $er->createQueryBuilder('u')->where('u.baja = 0');
                },
                "attr" => [
                    "class" => "chosen-select form-control"
                ]
            ))

            ->add('rol', EntityType::class, [
                'label' => 'Rol *',
                'empty_value' => '',
                'class'=>"AppBundle:Rol",
                'choice_label' => 'getNombre',
                'query_builder' => function (EntityRepository $er){
                    return $er->createQueryBuilder('u')->where('u.baja = 0');
                },
                "attr" => [
                    "class" => "chosen-select-rol form-control"
                ]
            ]);
        }catch(Exception $e){
            echo("elrror es ". $e->getMessage());
        }
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
