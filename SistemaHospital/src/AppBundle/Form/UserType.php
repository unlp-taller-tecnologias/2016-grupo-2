<?php

namespace AppBundle\Form;

use AppBundle\AppBundle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class UserType extends AbstractType
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
            ->add("username", "text",[
            'label' => 'Nombre de Usuario',
            "attr" => [
                "class" => "form-control"
            ]
            ])
            ->add("email", "email",[
                'label' => 'E-Mail',
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add("plainPassword", "repeated", [
                "type" => "password",
                "invalid_message" => "Las contraseñas no coinciden.",
                "required" => true,
                "first_options" => [
                    "label" => 'Contraseña',
                    "attr" => [
                        "class" => "form-control"
                    ]],
                "second_options" => [
                    "label" => 'Confirmar Contraseña',
                    "attr" => [
                        "class" => "form-control"
                    ]]
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    public function getParent()
    {
        return 'fos_user_registration';
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    // For Symfony 2.x
    public function getPersonal()
    {
        return $this->getBlockPrefix();
    }


}
