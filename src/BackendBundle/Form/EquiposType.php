<?php

namespace BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EquiposType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('nombreequipo', TextType::class, array(
                    'attr' => array(
                        'class' => 'form-control',
                        'id' => 'validationCustom01',
                        'placeholder' => 'Nombre del equipo...',
                        'required',
                        'maxlength' => '100',
                        'pattern' => "[A-Za-z0-9 ]+"),
                    'label' => false
                ))
                ->add('descripcion', TextareaType::class, array(
                    'attr' => array(
                        'class' => 'form-control',
                        'id' => 'validationCustom03',
                        'placeholder' => 'Descripción del equipo...',
                        'rows' => 4,
                        'required',
                        'pattern' => "[A-Za-z0-9 .,]+"),
                    'label' => false
                ))
                ->add('numerocontrol', NumberType::class, array(
                    'attr' => array(
                        'class' => 'form-control',
                        'id' => 'validationCustom02',
                        'placeholder' => 'Numero de control...',
                        'required',
                        'maxlength' => '9',
                        'pattern' => "[0-9]+"),
                    'label' => false
                ))
                ->add('tipoequipo', ChoiceType::class, [
                    'choices' => [
                        'Tipos De Equipos:' => [
                            'RJ45' => 'RJ45',
                            'Tablet' => 'Tablet',
                            'Switch' => 'Switch',
                            'Celular' => 'Celular',
                            'Routers' => 'Routers',
                            'Arduino' => 'Arduino',
                            'Cargador' => 'Cargador',
                            'Telefono IP' => 'Telefono IP',
                            'Computadora' => 'Computadora',
                        ]
                    ],
                    'placeholder' => 'Selecciona tipo de equipo...',
                    'attr' => array(
                        'class' => 'form-control',
                        'id' => 'validationCustom04',
                        'required'),
                    'label' => false
                ])
                ->add('registrar', SubmitType::class, array(
                    'attr' => array(
                        'class' => 'btn btn-success'),
                ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'BackendBundle\Entity\Equipos'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'backendbundle_equipos';
    }

}
