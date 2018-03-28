<?php

namespace ApiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RestaurantController extends Controller{
	
	public function listAction(Request $request){
		$em= $this->getDoctrine()->getManager();
		$restaurants_repo=$em->getRepository("BackendBundle:Restaurants");
		
		$postcode= $request->query->get('pc');
		$filter = $request->query->get('category');
		
		if ($filter==null || $filter==""){
		
		
		$query =$restaurants_repo->createQueryBuilder('r')
				->where ('r.postCode BETWEEN :pc -10 AND :pc +10')
				->setParameter('pc',$postcode)
				->getQuery();
		
		} else {
			$filters = explode("/", $filter);
		
		$query =$restaurants_repo->createQueryBuilder('r')
				->where ('r.category IN (:categories) AND (r.postCode BETWEEN :pc -10 AND :pc +10)')
				->setParameter('categories',$filters)
				->setParameter('pc',$postcode)
				->getQuery();
		}
		
		
		$restaurant_isset=$query->getResult();
				//if (count($user_isset)==0){
		
		$array = array();
		foreach ($restaurant_isset as $restaurant){
			$array[]= array(
				"id" => $restaurant->getId(),
				"description" => $restaurant->getDescription(),
				"minOrder" => $restaurant->getMinOrder(),
				"deliveryCost" => $restaurant->getDeliveryCost(),
				"image" => $restaurant->getImage(),
				"category" => $restaurant->getCategory(),
				"street" => $restaurant->getStreet(),
				"num" => $restaurant->getNum(),
				"postCode" => $restaurant->getPostCode(),
				"days" => $restaurant->getDays(),
				"startTime" => $restaurant->getStartTime(),
				"endTime" => $restaurant->getEndTime(),
				);
		}
		
		
		return $this->json($array);
	}
	
	
}
