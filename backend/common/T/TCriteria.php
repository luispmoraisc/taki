<?php
	namespace T;
	// classe TCriteria
	// essa classe provê uma interface utilizada para definição de critérios

	final class TCriteria extends TExpression{
		private $expressions; // armazena a lista de expressões
		private $operators; // armazena a lista de operators
		private $properties; // properties do critério
		private $joins;

		// método construtor
		function __construct(){
			$this->expressions = array();
			$this->operators = array();
			$this->joins = array();
		}

		/*
			método add()
			adiciona uma expressão ao critério
			@param $expression = expression (objeto TExpression)
			@param $operators = operator lógico de comparação
		*/
		public function add(TExpression $expression, $operator = self::AND_OPERATOR){
			// na primeira vez, não precisamos de operator lógico para concatenar
			if(empty($this->expressions)){
				$operator = NULL;
			}

			// agrega o resultado da expression à lista de expressões
			$this->expressions[] = $expression;
			$this->operators[] = $operator;
		}

		/* método dump()
		   retorna a expressão final
		*/

		public function dump(){
			//concatena a lista de expressões
			if(is_array($this->expressions)){
				if(count($this->expressions) > 0){
					$result = '';
					foreach($this->expressions as $i=> $expression){
						$operator = $this->operators[$i];
						// concatena o operator com a respectiva expressão
						$result .= $operator. $expression->dump(). ' ';
					}

					$result = trim($result);
					return "({$result})";
				}
			}
		}

		/*
			método setProperty()
			define o valor de uma propriedade
			@param $property = propriedade
			@param $value = valor
		*/

		public function setProperty($property,$value){
			if(isset($value)){
				$this->properties[$property] = $value;
			}else{
				$this->properties[$property] = NULL;
			}
		}		

		/*
			método getProperty()
			retorna o valor de uma propriedade
			@param $property = propriedade
		*/

		public function getProperty($property){
			if(isset($this->properties[$property])){
				return $this->properties[$property];
			}
		}

		/*
			método setJoin()
			retorna conjunto de instruções de inner join, left join, etc
			@param $option = opção de junção
			@param $values = array de instruções
		*/

		public function setJoin($option, $values){
			if(is_array($values)){					
			$result = ' ';			
				foreach ($values as $key => $value) {
					$result .= $option . ' '. $value. ' ';	
				}				
				$this->joins[$option] = $result;
			}
		}

		public function getJoin($join){
			if(isset($this->joins[$join])){
				return $this->joins[$join];
			}
		}
	}


?>