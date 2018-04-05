<?php

namespace DashboardBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use BackendBundle\Entity\Users;
use DashboardBundle\Form\RegisterType;
use DashboardBundle\Form\UserEditType;
use Symfony\Component\HttpFoundation\Session\Session;
class UserController extends Controller{
	private $session;
	
	public function __construct() {
		$this->session=new Session();
	}
	
	public function loginAction(Request $request){
		
//		$user = new Users();
//		
//		$user->setEmail("roberto@roberto.com");
//		$user->setNick("roberto");
//		
//		$factory= $this->get("security.encoder_factory");
//		$encoder = $factory->getEncoder($user);
//		$password = $encoder->encodePassword("roberto", $user->getSalt());
//		
//		
//		$em= $this->getDoctrine()->getManager();
//		$em->persist($user);
//		$em->flush();
		
		$autenticationUtils=$this->get('security.authentication_utils');
		$error= $autenticationUtils->getLastAuthenticationError();
		$lastUsername= $autenticationUtils->getLastUsername();
		if ($error){
			$this->session->getFlashBag()->add("warning","Usuario o Contraseña incorrectos");
		}
		return $this->render('DashboardBundle:User:login.html.twig',array(
		'last_username'=>$lastUsername,
			'error'=>$error,
	));
		
	}
	
	public function login2Action(Request $request){
		$jwt_auth =$this->get("app.jwt_auth");
		
		//Recibir json por post
		
		$json = $request->get("json",null);
		
		if ($json != null) {
			$params = json_decode($json);
			
			$email = (isset($params->email)) ? $params->email : null;
			$password = (isset($params->password)) ? $params->password : null;
			$pwd=hash('sha256',$password);
			
			$signup=$jwt_auth->signup($email,$pwd);
			
			//Comprobamos que se ha logueado correctamente
			
			if ($signup == 'error'){
			
				$response = array ("Error"=> "User not found");
				return new JsonResponse($response,404);
			}
			
			//Devolver rl token en formato json
			$response = array("token"=> $signup); 
			return new JsonResponse($response,200);
			
			
			} else{ 
				$response = array ("Error"=> "Parameter 'json' not found on Request");
				
				return new JsonResponse($response,400);
				
			}
		die();
	}
	
	public function pruebaAction(Request $request){
		
		$jwt_auth =$this->get("app.jwt_auth");
		// por si no lo lleva en la cabecera
		$check = false;
		
		$hash=$request->headers->get('token');
		$check =$jwt_auth->checkToken($hash);
		if ($check == false){
		$response = array ("Error"=> "Not Authorized");
		return new JsonResponse($response,401);
		
		}
		$response = array ("OKK"=> "Todo ok");
		return new JsonResponse($response,200);		
		
	}
	
	public function register2Action(Request $request){
		
		$json=$request->get("json",null);
		$params = json_decode($json);
			$data = array();
		if($json != null){
			
			$role="ROLE_USER";
			$email = (isset($params->email)) ? $params->email : null;
			$name = (isset($params->name)) ? $params->name : null;
			$surname = (isset($params->surname)) ? $params->surname : null;
			$password = (isset($params->password)) ? $params->password : null;
			$nick = (isset($params->nick)) ? $params->nick : null;
			$bio = (isset($params->bio)) ? $params->bio : null;
			$image=null;
			
			$user = new Users();
			//cifrar la password
		$pwd=hash('sha256',$password);
			
			
			$user->setBio($bio);
			$user->setEmail($email);
			$user->setImage($image);
			$user->setName($name);
			$user->setNick($nick);
			$user->setPassword($pwd);
			$user->setRole($role);
			$user->setSurname($surname);
			
			
			
			$em= $this->getDoctrine()->getManager();
			$isset_user =$em->getRepository("BackendBundle:Users")->findBy(
					array(
						"email"=>$email
					));
			if (count($isset_user==0)){
				$em->persist($user);
				$em->flush();
				$data=array("Ok"=>"user created");
			}else{
				$data=array("Error"=>"email duplicated");
				
			}
			
		} else {
			$data=array("Error"=>"not json");
		}
			
			return new JsonResponse($data);
	}
	
	public function registerAction(Request $request){
		
		$user= new Users();
	$form = $this->createForm(RegisterType::class,$user);
	
	
	$form->handleRequest($request);
		if ($form->isSubmitted()){
			
			if ($form->isValid()){
				
				
				$em=$this->getDoctrine()->getManager();
				$query= $em->createQuery('SELECT u FROM BackendBundle:Users u where u.email=:email or u.nick=:nick')
						->setParameter('email',$form->get("email")->getData())
						->setParameter ('nick',$form->get("nick")->getData());
				$user_isset=$query->getResult();
				
				
				
				$alert="warning";
				if (count($user_isset)==0){
				$factory=$this->get("security.encoder_factory");
					$encoder= $factory->getEncoder($user);
					$password = $encoder->encodePassword($form->get("password")->getData(),$user->getSalt());
					
				$user->setPassword($password);	
				$user->setRole("ROLE_OWNER");
				$em->persist($user);
				$flush= $em->flush();
					
				if ($flush==null){
					$status="Te has registrado correctamente";
					$alert="success";				}
				else{$status="No te has registrado correctamente";}
				}else{$status= "El usuario ya existe";}
			}else{
				$status="No te has registrado correctamente";
			}
			$this->session->getFlashBag()->add($alert,$status);
		
		}
	
	
	return $this->render('DashboardBundle:User:register.html.twig',array(
		"form"=>$form->createView()
	));
}
	public function editUserAction (Request $request){
		$user=$this->getUser();
		$user_image=$user->getImage();
		$form =$this->createForm(UserEditType::class,$user);
		
		$form->handleRequest($request);
		$alert="success";
		if ($form->isSubmitted()){
			if ($form->isValid()){
				$em=$this->getDoctrine()->getManager();
				
				$query= $em->createQuery('SELECT u FROM BackendBundle:Users u where u.email=:email or u.nick=:nick')
						->setParameter('email',$form->get("email")->getData())
						->setParameter ('nick',$form->get("nick")->getData());
				$user_isset=$query->getResult();
				if ( count($user_isset)==0 || ($user->getEmail() == $user_isset[0]->getEmail() && $user->getNick()==$user_isset[0]->getNick()) ){
					//upload file
					$file=$form["image"]->getData();
					if(!empty($file) && $file!=null){
						$ext=$file->guessExtension();
						if($ext=='jpg' ||$ext=='jpeg'|| $ext=='png'|| $ext=='gif'){
							$file_name=$user->getId().time().'.'.$ext;
							$file->move("uploads/users",$file_name);
							$user->setImage($file_name);
						}
					}else{
						$user->setImage($user_image);
					}
				
				$em->persist($user);
				$flush= $em->flush();
				
				if ($flush==null){
					$status="Has modificado tus datos correctamente";
					
				}
				else{$status="No has modificado tus datos correctamente";}
				}else{$status= "El usuario ya existe";}
			}else{
				$status="No se han actualizado los datos";
			}
			$this->session->getFlashBag()->add($alert,$status);
			return $this->redirect('my-data');
		}
		
		
		
		
		
		return $this->render('DashboardBundle:User:edit_user.html.twig' # sabe que las vistas del directorio user correspnden al user cntroler
				, array (
					"form" => $form->createView()
				)); 
	}
	public function deleteAction(Request $request) {

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
		$id = $user_repo->find($id);

		if ($id == null) {

			$response = array("Error" => "User does not exists");
			return new JsonResponse($response, 404);
		} else {
				$em->remove($id);

				$flush = $em->flush();
				if ($flush==null){
					$response = array("Ok" => "User deleted");
				return new JsonResponse($response, 200);
				}
				
		
				$response = array("Error" => "User could not be deleted");
				return new JsonResponse($response, 403);
			
		}
	}
	public function updateAction(Request $request){
		$jwt_auth =$this->get("app.jwt_auth");
		// por si no lo lleva en la cabecera
		$check = false;
		
		$hash=$request->headers->get('token');
		$check =$jwt_auth->checkToken($hash,true);
		if ($check == false){
		$response = array ("Error"=> "Not Authorized");
		return new JsonResponse($response,401);
		}
		$em = $this->getDoctrine()->getManager();
		$id=$check->sub;
		$user_repo=$em->getRepository("BackendBundle:Users");
		$user = $user_repo->findOneBy(array(
				"id"=>$id
				));
		
		
		// json body
		$json=$request->get("json",null);
		$params = json_decode($json);
			$data = array();
			
			
			if($json != null){
			
				
				if (isset($params->email)){
					$query = $user_repo->createQueryBuilder('u')
							->where('u.email=:email and u.id!=:id ')
						->setParameter('email',$params->email)
							->setParameter('id',$id)
							->getQuery();
				$user_isset=$query->getResult();
				if (count($user_isset)==0){
					
					$user->setEmail($params->email);
				}else {
					
				$response = array ("Error"=> "email already exists");
		return new JsonResponse($response,409);
				
			}
				}
				if (isset($params->name)){
					$user->setName($params->name);
				}
				if (isset($params->surname)){
					$user->setSurname($params->surname);
				
				}
				if (isset($params->password)){
					$pwd=hash('sha256',$params->password);
					$user->setPassword($pwd);
				}
				if (isset($params->nick)){
					$query = $user_repo->createQueryBuilder('u')
							->where('u.nick=:nick and u.id!=:id ')
						->setParameter('nick',$params->nick)
							->setParameter('id',$id)
							->getQuery();
				$user_isset=$query->getResult();
				if (count($user_isset)==0){
					
					$user->setNick($params->nick);
				}else {
					echo(count($user_isset));
				$response = array ("Error"=> "nick already exists");
		return new JsonResponse($response,409);
				
			}
				
				}
				if (isset($params->bio)){
					$user->setBio($params->bio);
				}
				$em->persist($user);
				$em->flush();
			$response = array ("Ok"=> "user updated");
		return new JsonResponse($response,200);
				
			} else {
				$response = array ("Error"=> "not json");
		return new JsonResponse($response,400);
				
			}
			
	}

	public function uploadImageAction(Request $request){
		$jwt_auth =$this->get("app.jwt_auth");
		// por si no lo lleva en la cabecera
		$check = false;
		
		$hash=$request->headers->get('token');
		$check =$jwt_auth->checkToken($hash,true);
		if ($check == false){
		$response = array ("Error"=> "Not Authorized");
		return new JsonResponse($response,401);
		
		}
		$em = $this->getDoctrine()->getManager();
		$user = $em->getRepository("BackendBundle:Users")->findOneBy(array(
				"id"=>$check->sub
				));
		$file =$request->files->get("image");
		if(!empty($file) &&$file != null){
			$ext = $file->guessExtension();
			if($ext=='jpeg'||$ext=='jpg'||$ext=='gif'||$ext=='png'){
			$file_name = time().".".$ext;
			$file->move("uploads/users",$file_name);
			
			$user->setImage($file_name);
			$em->persist($user);
			$em->flush();
			
			$response = array ("Ok"=> "imagen cambiada");
		}else{
			$response = array ("Error"=> "file not valid");
		}}else { $response = array ("Error"=> "imagen vacia");}
		
		return new JsonResponse($response,200);		
	}
}


