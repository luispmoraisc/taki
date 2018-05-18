<?php		
	header('Content-Type: text/html; charset=utf-8');
	// middleware e authentication	  
	header("Access-Control-Allow-Headers: Authorization, Content-Type");
	header("Access-Control-Allow-Methods: OPTIONS, GET, POST, DELETE");
	header('Access-Control-Allow-Origin: *');
	header("Content-Type: x-www-form-urlencoded");
	date_default_timezone_set('America/Sao_Paulo');

	require_once __DIR__.'/../vendor/autoload.php';
	require_once __DIR__ .'/../controllers/wrapper.php';
	require_once __DIR__ .'/../controllers/auth.php';		
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\HttpFoundation\Request;
	use Silex\Application;
	 
	$app = new Silex\Application();	

// - autenticação
	$app->post('/auth', function (Request $request) use ($app){		
		$dados = json_decode($request->getContent(), true);		
		$auth = Auth::Authentication($_POST['username'], $_POST['password']);

		if($auth != false){
			$jwt = JWTWrapper::encode([
	            'expiration_sec' => 360000,
	            'iss' => 'localhost',
	            'userdata' => [
	                'id' => $auth['id'],
	                'username' => $auth['user'],
	                'name' => $auth['name']	                
	            ]
	        ]);	     

			$jwtD = JWTWrapper::decode($jwt);			
	        return $app->json([
	        	'login' => 'true',
	        	'expire' => $jwtD->exp,
	        	'id' => $jwtD->data->id,
	        	'user' => $jwtD->data->name,        	
	        	'access_token' => $jwt
	        ]);
		}

		return $app->json([
			'login' => 'false',
			'message' => 'Login Inválido'
		]);		
	});

	// verificar token antes de qualquer requisição
	$app->before(function(Request $request, Application $app) {
	    $route = $request->get('_route');		     	
	    if($route != 'POST_auth') {
	        $authorization = $request->headers->get("Authorize");
	        if($authorization != '' || $authorization != null){
	        	list($jwt) = sscanf($authorization, 'Bearer %s');
	 
		        if($jwt) {
		            try {
		                $app['jwt'] = JWTWrapper::decode($jwt);
		            } catch(Exception $ex) {
		                // nao foi possivel decodificar o token jwt
		                return new Response('Acesso nao autorizado', 401);
		            }
		     
		        } else {
		            // nao foi possivel extrair token do header Authorization
		            return new Response('Token nao informado', 400);
		        }
	        }	        
	    }
	});


	$app->get("/menu", function ( Request $request ) use ($app){
		$menuJson = file_get_contents(__DIR__.'/../jsons/menu.json');
		return new Response($menuJson, 200);
	});

// - OPTIONS
	$app->OPTIONS("{anything}", function(){
		return new \Symfony\Component\HttpFoundation\JsonResponse(null, 204);
	})->assert("anything", ".*");
	$app['debug'] = true;
	$app->run();
?>