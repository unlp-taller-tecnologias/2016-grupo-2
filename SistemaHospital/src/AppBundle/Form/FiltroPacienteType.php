<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FiltroPacienteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("nombre", "text", [
                'label' => 'Nombre/s:',
                'required' => false,
                "attr" => [
                    "class" => "form-control"
                ]
            ])

            ->add("apellido", "text", [
                'label' => 'Apellido/s:',
                'required' => false,
                "attr" => [
                    "class" => "form-control"
                ]
            ])


//           ->add('edadmin', "integer", array(
//               'label' => 'Edad mínima:',
//               'required' => false,
//                'attr' => array(
//                    'min' => 0,
//                    'max' => 150,
//                    "class" => "form-control"
//                )
//            ))
//
//            ->add('edadmax', "integer", array(
//                'label' => 'Edad máxima:',
//                'required' => false,
//                'attr' => array(
//                    'min' => 0,
//                    'max' => 150,
//                    "class" => "form-control"
//                )
//            ))

            ->add('paciente', 'entity', array(
                'multiple' => false,   // Multiple selection allowed
                'expanded' => false,   // Render as checkboxes
                'label' => false,
                'class' => 'AppBundle:Paciente',
                'property' => 'getDni',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.baja = FALSE');
                },
                'choice_label'  => function ($paciente) {
                    return (string)("DNI: ".$paciente->getDni()."  Nombre y apellido: ".$paciente->getNombre()." ".$paciente->getApellido());
                },
                "placeholder" =>"Elige un Dni o Nombre o Apellido..",
                'required' => false,
                "attr" => [
                    "class" => "chosen-select form-control",
                ]
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Buscar Paciente',
                "attr" => [
                    "class" => "btn btn-primary col-md-offset-5"
                ]
            ));
    }

}
