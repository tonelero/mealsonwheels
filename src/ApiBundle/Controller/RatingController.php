<?php

namespace ApiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use BackendBundle\Entity\Ratings;

class RatingController extends Controller {

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
			$text = (isset($params->text)) ? $params->text : null;
			$points = (isset($params->points)) ? $params->points : null;

			$em = $this->getDoctrine()->getManager();

			$id = $check->sub;
			$user_repo = $em->getRepository('BackendBundle:Users');
			$id = $user_repo->find($id);


			$res_repo = $em->getRepository('BackendBundle:Restaurants');
			$res = $res_repo->find($restaurant);

			$rating = new Ratings();

			$rating->setCreatedAt(new \DateTime("now"));
			$rating->setUser($id);
			$rating->setText($text);
			$rating->setPoints($points);
			$rating->setRestaurant($res);

			if ($res == null) {

				$response = array("Error" => "Restaurant does not exists");
			} else {

				$em->persist($rating);
				$em->flush();
				$response = array("Ok" => "Rating created");
			}
		} else {
			$response = array("Error" => "Json not found");
		}
		return new JsonResponse($response);
	}

	public function listAction(Request $request, $restaurant = null) {
		$em = $this->getDoctrine()->getManager();
		$ratings_repo = $em->getRepository("BackendBundle:Ratings");

		if ($restaurant != null) {
			$query = $ratings_repo->createQueryBuilder('p')
					->where('p.restaurant = :res')
					->setParameter('res', $restaurant)
					->getQuery();
		}
		$ratings_isset = $query->getResult();

		$data = array();
		foreach ($ratings_isset as $rating) {
			$data[] = array(
				"user" => $rating->getUser()->getNick(),
				"date" => $rating->getCreatedAt(),
				"text" => $rating->getText(),
				"points" => $rating->getPoints(),
			);
		}


		return new JsonResponse($data, 200);
	}

	public function deleteAction(Request $request, $rating = null) {

		$jwt_auth = $this->get("app.jwt_auth");
		// por si no lo lleva en la cabecera
		$check = false;
		$hash = $request->headers->get('token');
		$check = $jwt_auth->checkToken($hash, true);
		if ($check == false) {
			$response = array("Error" => "Not Authorized");
			return new JsonResponse($response, 401);
		}

		$em = $this->getDoctrine()->getManager();

		$id = $check->sub;
		$user_repo = $em->getRepository('BackendBundle:Users');
		$id = $user_repo->find($id)->getId();


		$rating_repo = $em->getRepository('BackendBundle:Ratings');
		$rating = $rating_repo->find($rating);

		if ($rating == null) {

			$response = array("Error" => "Rating does not exists");
			return new JsonResponse($response, 404);
		} else {
			$user_rating = $rating->getUser();
			if ($user_rating->getId() == $id) {
				$em->remove($rating);

				$flush = $em->flush();
				$response = array("Ok" => "Rating deleted");
				return new JsonResponse($response, 200);
			} else {
				$response = array("Error" => "You are not the owner of such rating");
				return new JsonResponse($response, 403);
			}
		}
	}

}
