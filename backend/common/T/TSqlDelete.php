<?php
	namespace T;
	// TSqlDelete
	// instrução DELETE

	final class TSqlDelete extends TSqlInstruction{
		// método getInstruction()
		// retorna a instrução DELETE em forma de string
		public function getInstruction(){
			// monta a string de DELETE
			$this->sql = "DELETE FROM {$this->entity}";

			//retorna a cláusula WHERE do objeto $this->criteria
			if($this->criteria){
				$expression = $this->criteria->dump();
				if($expression){
					$this->sql .= ' WHERE ' .$expression;
				}
			}
			return $this->sql;
		}
	}

?>