<?php

namespace BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UsuarioType extends AbstractType {

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
                        'pattern' => "[A-Za-z0-9]+"),
                    'label' => false
                ))
                ->add('contrasena', PasswordType::class, array(
                    'attr' => array(
                        'class' => 'form-control form-control-user',
                        'id' => 'exampleInputPassword',
                        'placeholder' => 'Contraseña',
                         'maxlength' => '20'),
                    'label' => false
                ))
                ->add('iniciarSesion', SubmitType::class, array(
                    'attr' => array(
                        'class' => 'btn btn-secondary btn-user btn-block',
                        'placeholder' => 'Iniciar Sesión'),
                    'label' => 'Iniciar Sesión'
                ));
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
