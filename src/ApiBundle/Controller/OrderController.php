<?php

namespace ApiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


class OrderController extends Controller {

	public function listAction(Request $request, $user = null) {
		$em = $this->getDoctrine()->getManager();
		$orders_repo = $em->getRepository("BackendBundle:Orders");

		if ($user != null) {
			$query = $orders_repo->createQueryBuilder('o')
					->where('o.user = :user')
					->setParameter('user', $user)
					->orderBy('o.createdAt', 'ASC')
					->getQuery();
		}
		$order_isset = $query->getResult();

		$data = array();
		foreach ($order_isset as $order) {
			$data[] = array(
				"id" => $order->getId(),
				"created_at" => $order->getCreatedAt(),
				"restaurant" => $order->getRestaurant()->getId(),
			);
		}


		return new JsonResponse($data, 200);
	}

}
