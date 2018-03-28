<?php

namespace DashboardBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BackendBundle\Entity\Products;
use DashboardBundle\Form\ProductsType;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller{
	
	public function newAction(Request $request, $restaurant=null){
		
		
		// COmprobar que es el dueño del restaurante
	$product= new Products();
	$form = $this->createForm(ProductsType::class,$product);
	
	
	$form->handleRequest($request);
		if ($form->isSubmitted()){
			
			if ($form->isValid()){

				$em=$this->getDoctrine()->getManager();
				$res_repo=$em->getRepository("BackendBundle:Restaurants");
				$res_isset = $res_repo->find($restaurant);
					$product->setRestaurant($res_isset);
					
				$em->persist($product);
				$flush= $em->flush();
				
				if ($flush==null){
					$status="Te has registrado correctamente";
					//$this->session->getFlashBag()->add("status",$status);
					//return $this->redirect("login");
				}
				else{$status="No te has registrado correctamente";}
				}else{$status= "El restaurante ya existe";}
			}else{
				$status="No te has registrado correctamente";
			}
			//$this->session->getFlashBag()->add("status",$status);
		
	
	
	
	return $this->render('DashboardBundle:Products:register.html.twig',array(
		"form"=>$form->createView()
	));
}
public function listAction(Request $request, $restaurant=null) {
		$em = $this->getDoctrine()->getManager();
		//$user = $this->getUser();
		$products_repo = $em->getRepository('BackendBundle:Products');


		$products = $products_repo->findBy(array('restaurant' => $restaurant));
		
		$res_repo = $em->getRepository('BackendBundle:Restaurants');


		$restaurant = $res_repo->find($restaurant);

		
		return $this->render('DashboardBundle:Products:list.html.twig', array(
					'products' => $products,
			'restaurant' => $restaurant,
		));
	}
public function editAction(Request $request, $id = null) {
		$em = $this->getDoctrine()->getManager();
		$user = $this->getUser();
		$products_repo = $em->getRepository('BackendBundle:Products');
		$product = $products_repo->find($id);

		$form = $this->createForm(ProductsType::class, $product);


		$form->handleRequest($request);
		if ($form->isSubmitted()) {

			if ($form->isValid()) {

				$em->persist($product);
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




		return $this->render('DashboardBundle:Products:edit.html.twig', array(
					"form" => $form->createView(),
					"product" => $product,
		));
	}
	
public function deleteAction(Request $request, $id = null) {
		$em = $this->getDoctrine()->getManager();
		$user = $this->getUser();
		$products_repo = $em->getRepository('BackendBundle:Products');
		$product = $products_repo->find($id);


		if ($user->getId() == $product->getRestaurant()->getUser()->getId()) {
			$em->remove($product);

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
}