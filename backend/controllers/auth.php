<?php			
	use T\TConnection;
	use T\TSqlSelect;
	use T\TCriteria;
	use T\TFilter;				
	class Auth{
		// autenticação
		public static function Authentication($user, $pass){			
			$credentialsAreValid = false;
			$conn = TConnection::open('api');	
			$auth = new TSqlSelect;
			$criterio = new TCriteria;
			$criterio->add(new TFilter('username',' = ', $user));
			$criterio->add(new TFilter(' password',' = ', md5($pass)));			
			//$criterio->add(new TFilter(' password',' = ', $_POST['password']), 'OR');
			$auth->setEntity('admin');
			$auth->addColumn('admin.*');
			$auth->setCriteria($criterio);		
			try{							
				$select = $conn->query($auth->getInstruction());		
				$rowCount = $select->rowCount();		
				if($rowCount >= 1){
					$row = $select->fetch(PDO::FETCH_ASSOC);					
					$credentialsAreValid = true;
					$user = $row['username'];
					$id = $row['id_user'];
					$name = $row['name'];									
					return array('user' => $user, 'id' => $id, 'name' => $name);
				}else{
					return false;
				}
			}catch(PDOException $e){
				print "Erro!: " .$e->getMessage() . "<br>\n";
				die();
			}	
		}
	}
?>