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

class OrderDetailsType extends AbstractType {

	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
				->add('aver', ChoiceType::class, array(
					'label' => 'Añadir Producto',
					'required' => 'required',
					'mapped'=>false,
					'choices' => $options['list'],'attr' => array(
						'class' => 'mdb-select selectCenter',
						'data-live-search'=> "true",
						
					)
				))
				->add('quantity', ChoiceType::class, array(
					'label' => 'Cantidad',
					'required' => 'required',
					'choices' => array(
						'1' => '1',
						'2' => '2',
						'3' => '3',
						'4' => '4',
						'5' => '5',
						'6' => '6',
						'7' => '7',
						'8' => '8',
						'9' => '9',
						'10' => '10',
						
					),'attr' => array(
						'class' => 'mdb-select'
					)
				))
				
				->add('anyadir', SubmitType::class, array(
					'label' => 'Añadir',
					"attr" => array(
						"class" => "form-submit btn btn-success"
					)
		));
		;
	}

/**
	 * {@inheritdoc}
	 */

	public function configureOptions(OptionsResolver $resolver) {
		 $resolver->setRequired('list');
		$resolver->setDefaults(array(
			'data_class' => 'BackendBundle\Entity\OrderDetails'
		));
	}

	/**
	 * {@inheritdoc}
	 */
	public function getBlockPrefix() {
		return 'backendbundle_restaurants';
	}

}
