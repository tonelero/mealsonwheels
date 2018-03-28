<?php

namespace DashboardBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BackendBundle\Entity\OrderDetails;
use DashboardBundle\Form\OrderDetailsType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
class OrderController extends Controller{
	
	
public function listAction(Request $request) {
		$em = $this->getDoctrine()->getManager();
		$user = $this->getUser();
		$orders_repo = $em->getRepository('BackendBundle:Orders');
		$query =$orders_repo->createQueryBuilder('o')
				->join('o.restaurant','r')
				->where ('r.user = (:user) and o.valid=1')
				->setParameter('user',$user)
				->orderBy('o.createdAt','ASC')
				->getQuery();

		$order_isset=$query->getResult();
		

		
		return $this->render('DashboardBundle:Orders:list.html.twig', array(
					'orders' => $order_isset,
		));
	}
public function editAction(Request $request, $id = null) {
		$em = $this->getDoctrine()->getManager();
//		
//		
		$order_repo = $em->getRepository('BackendBundle:Orders');
		$orderProduct = $order_repo->find($id);
//		
//		
//		
		$orders_repo = $em->getRepository('BackendBundle:OrderDetails');
	$products = $orders_repo->findBy(array('order'=>$id));
//

//		
		$productsRepo=$em->getRepository('BackendBundle:Products');
		$productos=$productsRepo->findBy(array('restaurant'=>$orderProduct->getRestaurant()));
		$lista = $productos;
		$listanueva;
		foreach ($lista as $producto){
			$nombre=$producto->getName();
			$listanueva[ucfirst($nombre)]=$producto->getId();
		}

	
	$order = new OrderDetails();
		$form = $this->createForm(OrderDetailsType::class, $order,array('list'=>$listanueva));


		$form->handleRequest($request);
		if ($form->isSubmitted()) {

			if ($form->isValid()) {

				$prod = $form['aver']->getData();
				$order->setOrder($orderProduct);
				
				$prodObject=$productsRepo->find($prod);
				$order->setProduct($prodObject);
				$em->persist($order);
				$flush = $em->flush();
			
			} else {
				$status = "El restaurante ya existe";
			}
		} else {
			$status = "No te has registrado correctamente";
		}
		//$this->session->getFlashBag()->add("status",$status);




		return $this->render('DashboardBundle:Orders:edit.html.twig', array(
					"form" => $form->createView(),
					"products"=>$products
		));
	}
	
public function deleteAction(Request $request, $id = null) {
		$em = $this->getDoctrine()->getManager();
		$user = $this->getUser();
		$orders_repo = $em->getRepository('BackendBundle:OrderDetails');
		$order = $orders_repo->find($id);

		//var_dump($order);
		if ($user->getId() == $order->getProduct()->getRestaurant()->getUser()->getId()) {
			
			$em->remove($order);

			$flush = $em->flush();

			if ($flush == null) {
				$status = 'la publicacion ha sido borrada correctamente';
			} else {
				$status = 'la publicacion no se ha borrado';
			}
		} else {
			$status = 'la publicacion no se ha borrado';
		}
		return $this->redirectToRoute('orderdetail_list', array('id' => $order->getOrder()->getId()));
	}
}