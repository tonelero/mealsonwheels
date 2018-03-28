<?php

namespace DashboardBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BackendBundle\Entity\Restaurants;
use DashboardBundle\Form\RestaurantsType;
use DashboardBundle\Form\RestaurantsEditType;
use Symfony\Component\HttpFoundation\Response;

class RestaurantController extends Controller {

	public function registerAction(Request $request) {
		$restaurant = new Restaurants();
		$form = $this->createForm(RestaurantsEditType::class, $restaurant);


		$form->handleRequest($request);
		if ($form->isSubmitted()) {

			if ($form->isValid()) {

				// upload image
				$file = $form['image']->getData();

				if (!empty($file) && $file != null) {
					$ext = $file->guessExtension();
					if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
						$file_name = $restaurant->getId() . time() . '.' . $ext;
						$file->move("uploads/restaurants", $file_name);
						$restaurant->setImage($file_name);
					} else {
						$restaurant->setImage(null);
					}
				} else {
					$restaurant->setImage(null);
				}





				$em = $this->getDoctrine()->getManager();
				//$user_repo=$em->getRepository("BackendBundle:User");


			//	$restaurant->setDays($form['days']->getData());
				$restaurant->setStartTime($this->update_time($form['startTime']->getData()));
				$restaurant->setEndTime($this->update_time($form['endTime']->getData()));
				$em->persist($restaurant);
				$flush = $em->flush();

				if ($flush == null) {
					$status = "Te has registrado correctamente";
					//$this->session->getFlashBag()->add("status",$status);
					//return $this->redirect("login");
				} else {
					$status = "No te has registrado correctamente";
				}
			} else {
				$status = "El restaurante ya existe";
			}
		} else {
			$status = "No te has registrado correctamente";
		}
		//$this->session->getFlashBag()->add("status",$status);




		return $this->render('DashboardBundle:Restaurant:register.html.twig', array(
					"form" => $form->createView()
		));
	}

	public function listAction(Request $request) {
		$em = $this->getDoctrine()->getManager();
		$user = $this->getUser();
		$restaurants_repo = $em->getRepository('BackendBundle:Restaurants');


		$restaurants = $restaurants_repo->findBy(array('user' => $user));
		$restaurant = new Restaurants();


		$form = $this->createForm(RestaurantsType::class, $restaurant);
		return $this->render('DashboardBundle:Restaurant:list.html.twig', array(
					'restaurants' => $restaurants,
					"form" => $form->createView()
		));
	}
	public function listProductAction(Request $request) {
		$em = $this->getDoctrine()->getManager();
		$user = $this->getUser();
		$restaurants_repo = $em->getRepository('BackendBundle:Restaurants');


		$restaurants = $restaurants_repo->findBy(array('user' => $user));
		$restaurant = new Restaurants();


		$form = $this->createForm(RestaurantsType::class, $restaurant);
		return $this->render('DashboardBundle:Restaurant:listProduct.html.twig', array(
					'restaurants' => $restaurants,
					"form" => $form->createView()
		));
	}

	public function editAction(Request $request, $id = null) {
		
		$em = $this->getDoctrine()->getManager();
		$user = $this->getUser();
		$restaurants_repo = $em->getRepository('BackendBundle:Restaurants');
		$restaurant = $restaurants_repo->find($id);

		$form = $this->createForm(RestaurantsType::class, $restaurant);

		
		$form->handleRequest($request);
		if ($form->isSubmitted()) {
			
			if ($form->isValid()) {
				
				// upload image
				$file = $form['image']->getData();

				if (!empty($file) && $file != null) {
					$ext = $file->guessExtension();
					if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
						$file_name = $restaurant->getId() . time() . '.' . $ext;
						$file->move("uploads/restaurants", $file_name);
						$restaurant->setImage($file_name);
					} else {
						$restaurant->setImage(null);
					}
				} else {
					$restaurant->setImage(null);
				}

				$restaurant->setDays($form['days']->getData());
				$restaurant->setStartTime($this->update_time($form['startTime']->getData()));
				$restaurant->setEndTime($this->update_time($form['endTime']->getData()));
				$em->persist($restaurant);
				$flush = $em->flush();

				if ($flush == null) {
					$status = "Te has registrado correctamente";
					//$this->session->getFlashBag()->add("status",$status);
					//return $this->redirect("login");
				} else {
					$status = "No te has registrado correctamente";
				}
			} else {
				$status = "El restaurante ya existe";
			}
		} else {
			$status = "No te has registrado correctamente";
		}
		//$this->session->getFlashBag()->add("status",$status);




		return $this->render('DashboardBundle:Restaurant:edit.html.twig', array(
					"form" => $form->createView(),
					"restaurant" => $restaurant,
		));
	}

	public function deleteAction(Request $request, $id = null) {
		$em = $this->getDoctrine()->getManager();
		$user = $this->getUser();
		$restaurants_repo = $em->getRepository('BackendBundle:Restaurants');
		$restaurant = $restaurants_repo->find($id);


		if ($user->getId() == $restaurant->getUser()->getId()) {
			$em->remove($restaurant);

			$flush = $em->flush();

			if ($flush == null) {
				$status = 'la publicacion ha sido borrada correctamente';
			} else {
				$status = 'la publicacion no se ha borrado';
			}
		} else {
			$status = 'la publicacion no se ha borrado';
		}
		return new Response($status);
	}

	function update_time($time) {
		$ap = $time[5] . $time[6];
		$ttt = explode(":", $time);
		$th = $ttt['0'];
		$tm = $ttt['1'];
		if ($ap == 'pm' || $ap == 'PM') {
			$th += 12;
			if ($th == 24) {
				$th = 12;
			}
		}
		if ($ap == 'am' || $ap == 'AM') {
			if ($th == 12) {
				$th = '00';
			}
		}
		$newtime = $th . ":" . $tm[0] . $tm[1];
		$time_array = explode(":", $newtime);
		$date = new \DateTime("now");
		$datetime = $date->setTime($time_array[0], $time_array[1]);
		return $datetime;
	}

}
