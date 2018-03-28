<?php

namespace DashboardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProductsType extends AbstractType {

	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add('name', TextType::class, array(
					'label' => 'Nombre del producto',
					'required' => 'required',
					'attr' => array(
						'class' => 'form-name form-control'
					)
				))
				->add('description', TextareaType::class, array(
					'label' => 'Descripcion del producto',
					'required' => 'required',
					'attr' => array(
						'class' => 'md-textarea form-control',
						'rows' => '2',
					)
				))
				->add('price', TextType::class, array(
					'label' => 'Precio del producto ',
					'required' => 'required',
					'attr' => array(
						'class' => 'form-name form-control'
					)
				))
				->add('type', ChoiceType::class, array(
					'label' => 'Tipo de producto',
					'required' => 'required',
					'choices' => array(
						'Primer plato' => 'primer plato',
						'Segundo plato' => 'segundo plato',
						'Postre' => 'postre',
						'Tapa' => 'tapa',
						'Otro' => 'otro',
					),"attr" => array(
						"class" => "mdb-select "
					)
				))
				
				->add('Registrar Producto', SubmitType::class, array(
					"attr" => array(
						"class" => "btn btn-outline-blue-grey"
					)
		));
		;
	}

/**
	 * {@inheritdoc}
	 */

	public function configureOptions(OptionsResolver $resolver) {
		$resolver->setDefaults(array(
			'data_class' => 'BackendBundle\Entity\Products'
		));
	}

	/**
	 * {@inheritdoc}
	 */
	public function getBlockPrefix() {
		return 'backendbundle_products';
	}

}
