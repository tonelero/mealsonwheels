<?php

namespace ApiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use BackendBundle\Entity\Orders;
use BackendBundle\Entity\OrderDetails;

class OrderDetailsController extends Controller {

	public function newAction(Request $request) {
		$json = $request->get("json", null);
		$jwt_auth = $this->get("app.jwt_auth");
		// por si no lo lleva en la cabecera
		$check = false;
		$hash = $request->headers->get('token');
		$check = $jwt_auth->checkToken($hash, true);
		if ($check == false) {
			$response = array("Error" => "Not Authorized");
			return new JsonResponse($response, 401);
		}

		$params = json_decode($json);
		if ($json != null) {
			$restaurant = (isset($params->restaurant)) ? $params->restaurant : null;
			$products = (isset($params->products)) ? $params->products : null;
			
			$products = explode("/", $products);
			
			
			$quantity = (isset($params->quantity)) ? $params->quantity : null;
			
			$quantities = explode("/", $quantity);

			$em = $this->getDoctrine()->getManager();

			$id = $check->sub;
			$user_repo = $em->getRepository('BackendBundle:Users');
			$id = $user_repo->find($id);
			;
			$res_repo = $em->getRepository('BackendBundle:Restaurants');
			$res = $res_repo->find($restaurant);
			
			

			$order = new Orders();

			$order->setCreatedAt(new \DateTime("now"));
			$order->setUser($id);
			$order->setRestaurant($res);
			$em->persist($order);
			
			for ($i=0; $i< sizeof($products); $i++) {
				$product=$products[$i];
			$prod_repo = $em->getRepository('BackendBundle:Products');
			$prod = $prod_repo->find($product);
			
			$orderdetail = new OrderDetails();

			$quantity=$quantities[$i];
			$orderdetail->setProduct($prod);
			$orderdetail->setOrder($order);
			$orderdetail->setQuantity($quantity);
			$em->persist($orderdetail);
		}

			if ($res == null) {

				$response = array("Error" => "Restaurant does not exists");
			} else {
				
				
				$em->flush();
				$response = array("Ok" => "Order created");
			}
		} else {
			$response = array("Error" => "Json not found");
		}
		return new JsonResponse($response);
	}

	public function listAction(Request $request, $order = null) {


		$em = $this->getDoctrine()->getManager();
		$orders_details_repo = $em->getRepository("BackendBundle:OrderDetails");


		if ($order != null) {
			$query = $orders_details_repo->createQueryBuilder('o')
					->where('o.order = :order')
					->setParameter('order', $order)
					->getQuery();
		}
		$order_isset = $query->getResult();

		$data = array();
		foreach ($order_isset as $order) {
			$data[] = array(
				"product" => $order->getProduct()->getName(),
				"quantity" => $order->getQuantity(),
				"price per product" => $order->getProduct()->getPrice(),
			);
		}

		return new JsonResponse($data, 200);
	}

}
