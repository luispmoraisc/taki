<?php
	namespace T;
	// definições de filtros de seleção

	class TFilter extends TExpression{
		private $variable;
		private $operator;
		private $value;

		public function __construct($variable,$operator,$value){
			// armazenando as propriedades
			$this->variable = $variable;
			$this->operator = $operator;
			//transformar value de acordo com regras
			$this->value = $this->transform($value);
		}

		private function transform($value){
			// se for array
			if(is_array($value)){
				//percorre os valuees
				foreach($value as $x){
					// se for um inteiro
					if(is_integer($x)){
						$foo[] = $x;
					}else if(is_string($value)){
						// se for string adicionar aspas
						$foo[] = "'$x'";
					}
				}
				// converter array em string separada por ","
				$result = '('.implode(',', $foo) . ')';
			}
			// caso seja uma string
			else if(is_string($value)){
				$result = "'$value'";
			}else if(is_null($value)){
				$result = 'NULL';
			}else if (is_bool($value)){
				$result = $value ? 'TRUE' : 'FALSE';
			}else{
				$result = $value;
			}
			return $result;
		}

		// retorna o filtro em forma de expressão
		public function dump(){
			return"{$this->variable}{$this->operator}{$this->value}";
		}
	}
?>