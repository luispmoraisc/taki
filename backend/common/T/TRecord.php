<?php
	namespace Project;
	abstract class T{
		protected $data; // array contendo os dados do objeto
		/*
			método __construct()
			instancia um Active Record. Se passado o $id, ja carrega o objeto
			@param [$id] = ID do Objeto
		*/

		public function __construct($id == null){
			if($id){ // se id for informado
				// carrega o objeto correspondente
				$object = $this->load($id);
				if($object){
					$this->fromArray($object->toArray());
				}
			}
		}

		/*
			método __clone()
			executado quando o objeto for clonado
			limpa o ID para que seja gerado um novo ID para o clone
		*/
		public function __clone(){
			unset($this->id);
		}

		// método set sera executado sempre que uma propriedade for atribuida

		public function __set($prop, $value){
			// verifica se existe método set_<propriedade>
			if(method_exists($this, 'set_'.$prop)){
				//executa o método set_<propriedade>
				call_user_func(array($this,'set_'.$prop),$value);
			}else{
				if($value == NULL){
					unset($this->data[$prop]);
				}else{
					//atribui o valor da propriedade
					$this->data[$prop] = $value;
				}
			}
		}

		// método get() que sera executada sempre que uma propriedade for requerida

		public function __get($prop){
			// verifica se existe método get_<propriedade>
			if(method_exists($this, 'get_'.$prop)){
				// executa o método get_<propriedade>
				return call_user_func(array($this, 'get_'.$prop));
			}else{
				//retorna o valor da propriedade
				if(isset($this->data[$prop])){
					return $this->data[$prop];
				}
			}
		}

		// método getEntity() retorna o nome da entidade (tabela)
		private function getEntity(){
			// obtem o nome da classe
			$class = get_class($this);
			//retorna a constante de classe TABLENAME
			return constant("{class}::TABLENAME");
		}

		//método fromArray() preenche os dados do objeto com um array
		public function fromArray($data){
			$this->data = $data;
		}

		//método toArray() retorna os dados do objeto como array
		public function toArray(){
			return $this->data;
		}

		//método store() armazena o objeto no BD e retorna o número de linhas afetadas pela instrução SQL (zero ou um)
		public function store(){
			// verifica se tem id ou se existe na base de dados
			if(empty($this->data['id']) or (!$this->load($this->id))){
				//incrementa o id
				if(empty($this->data['id'])){
					$this->id = $this->getLast() +1;
				}
				// cria uma instrução de insert
				$sql = new TSqlInsert;
				$sql->setEntity($this->getEntity());
				//percorre os dados do objeto
				foreach($this->data as $key => $value){
					//passa os dados do objeto para o SQL
					$sql->setRowData($key, $this->$key);
				}
			}else{
				// instancia instrução de update
				$sql = new TSqlUpdate;
				$sql->setEntity($this->getEntity());
				// cria critério de seleção através do ID
				$criteria = new TCriteria;
				$criteria->add(new TFilter('id','=', $this->id));
				$sql->setCriteria($criteria);
				// percorre os dados do objeto
				foreach ($this->data as $key => $value) {
					if($key !== 'id'){ // o ID não precisa ir no update
						// passa os dados do objeto para o SQL
						$sql->setRowData($key, $this->$key);
					}
				}
			}
			//obtem transação ativa
			if($conn = TTransaction::get()){
				// faz o log e executa o SQL
				TTransaction::log($sql->getInstruction());
				$result = $conn->exec($sql->getInstruction());
				//retorna o resultado
				return $result;
			}else{
				// se não tiver transação, retorna uma exceção
				throw new Exception("Não há transação ativa!!!");
				
			}
		}

		// método load() retorna um objeto do BD através de seu ID e instancia ele na memória @param $id = ID do objeto
		public function load($id){
			// instancia a instrução de SELECT
			$sql - new TSqlSelect;
			$sql->setEntity($this->getEntity());
			$sql->addColumn('*');

			// cria critério de seleção baseado no ID
			$criteria = new TCriteria;
			$criteria->add(new TFilter('id','=',$id));
			// define o critério de seleção de dados
			$sql->setCriteria($criteria);
			// obtem a transação ativa
			if($conn = TTransaction::get()){
				// cria mensagem de log e executa consulta
				TTransaction::log($sql->getInstruction());
				$result = $conn->Query($sql->getInstruction());
				// se retornou algum dado
				if($result){
					// retorna os dados em forma de objeto
					$object = $result->fetchObject(get_class($this));
				}
				return $object;
			}else{
				// se não tiver transação ativa
				throw new Exception("Não há transação ativa");
			}
		}

		// método delete() exclui um objeto do BD através do ID
		public function delete($id = NULL){
			// o $id é o parâmetro ou a propriedade ID
			$id = $id ? $id : $this->id;
			// instancia uma instrução de DELETE
			$sql = new TSqlDelete;
			$sql->setEntity($this->getEntity());

			// cria critério de seleção de dados
			$criteria = new TCriteria;
			$criteria->add(new TFilter('id','=', $id));
			// define o critério de seleção conforme o ID
			$sql->setCriteria($criteria);

			// obtem a transação ativa
			if($conn = TTransaction::get()){
				TTransaction::log($sql->getInstruction());
				$result = $conn->exec($sql->getInstruction());
				// retorna o resultado
				return $result;
			}else{
				throw new Exception("Não há transação");
			}
		}

		// método getLast() retorna o ultimo ID inserido no BD
		private function getLast(){
			// inicia transação
			if($conn = TTransaction::get()){
				// instancia instrução de SELECT
				$sql = new TSqlSelect;
				$sql->addColumn('max(ID) as ID');
				$sql->setEntity($this->getEntity());
				// cria log e executa a instrução SQL
				TTransaction::log($sql->getInstruction());
				$result = $conn->Query($sql->getInstruction());
				// retorna os dados do banco
				$row = $result->fetch();
				return $row[0];
			}else{
				throw new Exception("Não há transação!!!");
				
			}
		}
	}
?>