<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FechaPendientesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           ->add("fechaPend", "text", [
                'label' => false,
                'required' => false,
                "attr" => [
                    "class" => "col-md-4 form-control datetimepickerWithoutTime"
                ]
            ])
            ->add('save', SubmitType::class, array(
                'label' => 'ver reservas',
                "attr" => [
                    "class" => "btn btn-primary"
                ]
            ));
    }

}
