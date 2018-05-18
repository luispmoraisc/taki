<?php
	namespace T;
	// TSqlSelect
	// instrução SELECT
	final class TSqlSelect extends TSqlInstruction{
		private $columns;

		// adiciona uma coluna a ser retornada pelo SELECT
		// @param $column = coluna da tabela
		public function addColumn($column){
			//adiciona a coluna no array
			$this->columns[] = $column;
		}

		// método getInstruction()
		// retorna a instrução SELECT em forma de string
		public function getInstruction(){
			$this->sql = 'SELECT ';
			$this->sql .= implode(',', $this->columns);
			$this->sql .= ' FROM ' .$this->entity;

			if($this->criteria){				
				$expression = $this->criteria->dump();

				$inner = $this->criteria->getJoin('inner join');

				if($inner){
					$this->sql .= $inner;
				}

				if($expression){
					$this->sql .=' WHERE ' .$expression;
				}

				// obtem as propriedades do critério
				$order = $this->criteria->getProperty('order');
				$limit = $this->criteria->getProperty('limit');
				$offset = $this->criteria->getProperty('offset');

				if($order){
					$this->sql .=' ORDER BY ' .$order;
				}
				if($limit){
					$this->sql .=' LIMIT ' .$limit;
				}
				if($offset){
					$this->sql .=' OFFSET ' .$offset;
				}
			}
			return $this->sql;
		}
	}
?>