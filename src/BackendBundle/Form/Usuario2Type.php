<?php

namespace BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class Usuario2Type extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('nombreusuario', TextType::class, array(
                    'attr' => array(
                        'class' => 'form-control form-control-user',
                        'id' => 'exampleInputEmail',
                        'aria-describedby' => 'emailHelp',
                        'placeholder' => 'Usuario',
                        'maxlength' => '45',
                        'pattern' => "[A-Za-zÑñáÁ 0-9 ]+"),
                    'label' => 'Nombre de Usuario'
                ))
                ->add('contrasena', PasswordType::class, array(
                    'attr' => array(
                        'class' => 'form-control form-control-user',
                        'id' => 'exampleInputPassword',
                        'placeholder' => 'Contraseña',
                        'maxlength' => '20',
                        'pattern' => "[A-Za-zÑñáÁ 0-9 ]+"),
                    'label' => 'Contraseña'
                ))
                ->add('rol', ChoiceType::class, [
                    'choices' => [
                        'Rol del usuario:' => [
                            'Administrador' => 'ROLE_ADMIN',
                            'Becario' => 'ROLE_BECARIO'
                        ]
                    ],
                    'placeholder' => 'Selecciona tipo de rol...',
                    'attr' => array(
                        'class' => 'form-control',
                        'id' => 'validationCustom04',
                    ),
                    'label' => 'Rol del usuario'
                ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'BackendBundle\Entity\Usuario'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'backendbundle_usuario';
    }

}
