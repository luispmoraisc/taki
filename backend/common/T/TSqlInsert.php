<?php
	namespace T;
	// classe para insert no BD
	final class TSqlInsert extends TSqlInstruction{
		private $columnValues;

		/*
			método setRowData()
			atribui valores à determinadas colunas no BD que serão inseridos
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

		/*
			método getInstruction()
			retorna a instrução de INSERT em forma de string
		*/

		public function getInstruction(){
			$this->sql = "INSERT INTO {$this->entity} (";
			//monta uma string contendo os nomes de colunas
			$columns = implode(', ', array_keys($this->columnValues));
			// monsta uma string contendo os valores
			$values = implode(', ', array_values($this->columnValues));
			$this->sql .= $columns .')';
			$this->sql .= " values ({$values})";
			return $this->sql;
		}
	}
?>