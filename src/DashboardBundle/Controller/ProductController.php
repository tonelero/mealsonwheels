<?php


namespace DashboardBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BackendBundle\Entity\Products;
use DashboardBundle\Form\ProductsType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
class ProductController extends Controller{
	private $session;
	public function __construct() {
		$this->session=new Session();
	}
	public function newAction(Request $request, $restaurant=null){
		
//$swagger = \Swagger\scan('C:\wamp64\www\meals_on_wheels\src');
//header('Content-Type: application/json');
//echo $swagger;
		
		// COmprobar que es el dueño del restaurante
	$product= new Products();
	$form = $this->createForm(ProductsType::class,$product);
	
	
	$form->handleRequest($request);
		if ($form->isSubmitted()){
			$alert="success";
			if ($form->isValid()){

				$em=$this->getDoctrine()->getManager();
				$res_repo=$em->getRepository("BackendBundle:Restaurants");
				$res_isset = $res_repo->find($restaurant);
					$product->setRestaurant($res_isset);
					
				$em->persist($product);
				$flush= $em->flush();
				
				if ($flush==null){
					
					$status="Has añadido el producto correctamente";
					//return $this->redirect("login");
				}
				else{$status="No has añadido el producto correctamente";}
				}else{
					$alert="error";
					$status= "No has añadido el producto correctamente";}
					$this->session->getFlashBag()->add($alert,$status);
			}else{
				$status="No has añadido el producto correctamente";
			}
			
		
	
	
	
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
			$alert="info";
			if ($form->isValid()) {

				$em->persist($product);
				$flush = $em->flush();
				
				if ($flush == null) {
					$status = "El producto se ha actualizado correctamente";
					//$this->session->getFlashBag()->add("status",$status);
					//return $this->redirect("login");
				} else {
					$alert="error";
					$status = "El producto no se ha actualizado";
				}
				
			
				
			} else {$alert="error";
					$status = "El producto no se ha actualizado";}
			$this->session->getFlashBag()->add($alert,$status);
			
		} 
		




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
				$status = 'El producto se ha borrado correctamente';
			} else {
				$status = 'El producto no se ha borrado';
			}
		} else {
			$status = 'El producto no se ha borrado';
		}
		$this->session->getFlashBag()->add("warning",$status);
		return new Response($status);
	}
}