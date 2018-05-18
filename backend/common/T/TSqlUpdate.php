<?php
	namespace T;
	// TSqlUpdate
	// instrução UPDATE
	final class TSqlUpdate extends TSqlInstruction{
		private $columnValues;
		/*
			método setRowData()
			Atribui valores à determinadas colunas no BD que serão modificadas
			@param $column = coluna da tabela
			@param $value = valor a ser armazenado
		*/
		public function setRowData($column,$value){
			// verifica se é um dado escalar (string,inteiro,..)
			if(is_scalar($value)){
				if(is_string($value)){
					// adiciona \ em aspas
					$value = addslashes($value);
					// caso seja uma string
					$this->columnValues[$column] = "'$value'";
				}
				else if(is_bool($value)){
					// caso seja um boolean
					$this->columnValues[$column] = $value;
				}
				else if($value !==''){
					// caso seja outro tipo de dado
					$this->columnValues[$column] = $value;
				}
				else{
					// caso seja NULL
					$this->columnValues[$column] = "NULL";
				}
			}
		}

		// método getInstruction()
		// retorna a instrução UPDATE em forma de string

		public function getInstruction(){
			//monta a string de UPDATE
			$this->sql = "UPDATE {$this->entity}";
			//monsta os pares: coluna=valor
			if($this->columnValues){
				foreach($this->columnValues as $column => $value){
					$set[] = "{$column} = {$value}";
				}
			}

			$this->sql .= ' SET ' .implode(', ', $set);
			//retorna a clásula WHERE do objeto $this->criteria
			if($this->criteria){
				$this->sql .= ' WHERE ' .$this->criteria->dump();
			}
			return $this->sql;
		}
	}
?>