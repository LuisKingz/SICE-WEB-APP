<?php

namespace BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

class PersonaType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('nombre', TextType::class, array(
                    'attr' => array(
                        'class' => 'form-control',
                        'id' => 'validationCustom01',
                        'placeholder' => 'Nombre',
                        'maxlength' => '45',
                        'pattern' => '[A-Za-z ]+',
                        'required'),
                    'label' => 'Nombre(s)'
                ))
                ->add('primerapellido', TextType::class, array(
                    'attr' => array(
                        'class' => 'form-control',
                        'id' => 'validationCustom02',
                        'placeholder' => 'Primer Apellido',
                        'maxlength' => '45',
                        'pattern' => '[A-Za-z ]+',
                        'required' => 'required'),
                    'label' => 'Primer Apellido'
                ))
                ->add('segundoapellido', TextType::class, array(
                    'attr' => array(
                        'class' => 'form-control',
                        'id' => 'validationCustom03',
                        'placeholder' => 'Segundo Apellido',
                        'maxlength' => '45',
                        'pattern' => '[A-Za-z ]+'
                    ),
                    'label' => 'Segundo Apellido'
                ))
                ->add('matricula', TextType::class, array(
                    'attr' => array(
                        'class' => 'form-control',
                        'id' => 'validationCustom04',
                        'placeholder' => 'Matricula',
                        'maxlength' => '11',
                        'pattern' => '[A-Za-z0-9]+'
                    ),
                    'label' => 'Matricula'
                ))
                ->add('submit', SubmitType::class, array(
                    'attr' => array(
                        'class' => 'btn btn-success ',
                        
                    ),
                    'label' => 'Registrar'
                ))
                
                ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'BackendBundle\Entity\Persona'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'backendbundle_persona';
    }

}
