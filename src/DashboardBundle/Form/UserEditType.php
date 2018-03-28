<?php

namespace DashboardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class UserEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('image', FileType::class,array(
			'label' => 'Avatar',
			'required' => false,
			'data_class'=>null,
			'attr' => array(
				'class'=>'form-image form-control '
			)
			
		))
				
				
				
				
				->add('name', TextType::class,array(
			'label' => 'Nombre',
			'required' => 'required',
			'attr' => array(
				'class'=>'form-name form-control'
			)
			
		))
		
				
				
				->add('surname', TextType::class,array(
			'label' => 'Surname',
			'required' => 'required',
			'attr' => array(
				'class'=>'form-surname form-control'
			)
			
		))
				
				->add('nick', TextType::class,array(
			'label' => 'Nick',
			'required' => 'required',
			'attr' => array(
				'class'=>'form-nick form-control nick-input'
			)
			
		))
				
				
				
				->add('email', EmailType::class,array(
			'label' => 'Correo electronico',
			'required' => 'required',
			'attr' => array(
				'class'=>'form-email form-control'
			)
			
		))
				
				
				
				->add('Registrarse', SubmitType::class, array(
					"attr" => array(
						"class"=> "form-submit btn btn-outline-blue-grey"
					)
				));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackendBundle\Entity\Users'
        ));
    }

    /**
     * {@inheritdoc}
     */
   


}
