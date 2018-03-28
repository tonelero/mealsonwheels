<?php

namespace ApiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductController extends Controller{
	
	public function listAction(Request $request, $restaurant=null){
		$em= $this->getDoctrine()->getManager();
		$products_repo=$em->getRepository("BackendBundle:Products");
		
		if ($restaurant != null){
			$query =$products_repo->createQueryBuilder('p')
				->where ('p.restaurant = :res')
				->setParameter('res',$restaurant)
				->getQuery();
		}
		$product_isset=$query->getResult();
		
		$data = array();
		foreach ($product_isset as $product){
			$data[]= array(
				"id" => $product->getId(),
				"name" => $product->getName(),
				"description" => $product->getDescription(),
				"price" => $product->getPrice(),
				"type" => $product->getType(),
				);
		}
		
		
		return new JsonResponse($data,200);
		
		
	}
	
	
	
}
