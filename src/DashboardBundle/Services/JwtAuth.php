<?php
namespace DashboardBundle\Services;
use Firebase\JWT\JWT;

class JwtAuth{
		public $managerRegistry;
 
    public function __construct($managerRegistry) {
        $this->managerRegistry = $managerRegistry;
    }
	
	public function signup($email, $password){
		$key = "clave-secreta";
		
	$user = $this->managerRegistry->getRepository("BackendBundle:Users")->findOneBy(
			array(
				"email" =>$email,
				"password" =>$password
			));
			$signup= false;
		if (is_object($user)){
			$signup = true;
		}
		
		if ($signup==true){
			$token = array(
				"sub"=> $user->getId(),
				"email"=> $user->getEmail(),
				"surname"=> $user->getSurname(),
				"name"=> $user->getName(),
				"iat"=> time(),
				"exp"=> time() + 600
				
			);
			
			$jwt=  JWT::encode($token, $key,'HS256');
			
			
			return $jwt;
			
		}else {
			return "error";
		}
	}
	
	public function checkToken($jwt,$getIdentity=false){
		$key = "clave-secreta";
		$auth = false;
		
		try{
			$decoded = JWT::decode($jwt, $key, array('HS256'));
		} catch(\Exception $e){
			//echo 'excepcion'. $e->getMessage();
			$decoded=false;
		}

		// comprueba que está logueado correctamente
		if (isset($decoded->sub)){
			$auth=true;
		}else {
			$auth=false;
		}
		
		if ($getIdentity ==true){
			return $decoded;
		}else {
			return $auth;
		}
	}
}
