<?php
	use \Firebase\JWT\JWT;	
	class JWTWrapper{
		const KEY = '7Fsxc2A865V6';

		public static function encode(array $options){
			$issuedAt = time();			
			$expire = $issuedAt + $options['expiration_sec'];
			$tokenParam = [
				'iat'	=> $issuedAt,
				'iss'	=> $options['iss'],
				'exp'	=> $expire,
				'nbf'	=> $issuedAt - 1,
				'data'	=> [
					'id' => $options['userdata']['id'],
	                'username' => $options['userdata']['username'],
	                'name' => $options['userdata']['name']	                
				],
			];			
			return JWT::encode($tokenParam, self::KEY);
		}

		public static function decode($jwt){
			return JWT::decode($jwt, self::KEY, ['HS256']);
		}
	}
?>