<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PersonalType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('baja')
            ->add('nombre')
            ->add('apellido')
            ->add('genero')
            ->add('dni')
            ->add('edad')
            ->add('servicios')
            ->add('operaciones')
            ->add('rol', EntityType::class, [
                'placeholder' => "- Seleccione una opción -",
                'class'=>"AppBundle:Rol",
                'choice_label' => 'getNombre',
            ]);;
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
