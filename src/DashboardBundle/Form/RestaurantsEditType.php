<?php

namespace DashboardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;

class RestaurantsEditType extends AbstractType {

	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add('image', FileType::class,array(
			'label' => 'Imagen ',
			'required' => false,
			'data_class'=>null,
			'attr' => array(
				'class'=>'form-image form-control '
			)
			
		))
				->add('name', TextType::class, array(
					'label' => 'Nombre',
					'required' => 'required',
					'attr' => array(
						'class' => 'form-name form-control'
					)
				))
				->add('description', TextareaType::class, array(
					'label' => 'Descripcion',
					'required' => 'required',
					'attr' => array(
						'class' => 'md-textarea form-control',
						'rows' => '2',
					)
				))
				->add('minOrder', TextType::class, array(
					'label' => 'Pedido Minimo ',
					'required' => 'required',
					'attr' => array(
						'class' => 'form-name form-control'
					)
				))
				->add('deliveryCost', TextType::class, array(
					'label' => 'Coste de entrega ',
					'required' => 'required',
					'attr' => array(
						'class' => 'form-name form-control'
					)
				))
				->add('image', FileType::class, array(
					'label' => 'Foto',
					'required' => false,
					'data_class' => null,
					'attr' => array(
						'class' => 'form-control'
					)
				))
				->add('street', TextType::class,array(
					'label' => 'Calle',
					'required' => 'required',
					'attr' => array(
						'class' => 'form-name form-control'
					)
				))
				->add('num', NumberType::class,array(
					'label' => 'Numero',
					'required' => 'required',
					'attr' => array(
						'class' => 'form-name form-control'
					)
				))
				->add('postCode', NumberType::class,array(
					'label' => 'Codigo Postal',
					'required' => 'required',
					'attr' => array(
						'class' => 'form-name form-control'
					)
					
				))
				->add('days', ChoiceType::class, array(
					'label' => 'Dias de reparto ',
				
					'required' => 'required',
					'choices' => array(
						'Lunes' => 'l',
						'Martes' => 'm',
						'Miércoles' => 'x',
						'Jueves' => 'j',
						'Viernes' => 'v',
						'Sábado' => 's',
						'Domingo' => 'd',
					), 'empty_data'=>'m','expanded' => true ,
					
					'multiple'=> true,
					'attr' => array(
						'class' => 'form-name form-check'
					)
				))
				->add('startTime', TextType::class, array(
					'label' => 'Hora comienzo ',
					'required' => 'false',
					"attr" => array(
						"class" => "my-time-picker",
						"id"=> "input_starttime",
						"placeholder"=>"Selecciona hora"
					),
					
				))
				->add('endTime', TextType::class, array(
					'label' => 'Hora cierre ',
					'required' => 'false',
					"attr" => array(
						"class" => "my-time-picker",
						"id"=> "input_starttime",
						"placeholder"=>"Selecciona hora"
					),
					
				))
				->add('Registrar Restaurante', SubmitType::class, array(
					"attr" => array(
						"class" => "form-submit btn btn-outline-blue-grey"
					)
		));
		;
	}

/**
	 * {@inheritdoc}
	 */

	public function configureOptions(OptionsResolver $resolver) {
		$resolver->setDefaults(array(
			'data_class' => 'BackendBundle\Entity\Restaurants'
		));
	}

	/**
	 * {@inheritdoc}
	 */
	public function getBlockPrefix() {
		return 'backendbundle_restaurants';
	}

}
