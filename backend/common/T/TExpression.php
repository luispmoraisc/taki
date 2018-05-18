<?php
	namespace T;
	// classe abstrata para gerenciar expressões
	abstract class TExpression{
		//operações lógicas
		const AND_OPERATOR = 'AND';
		const OR_OPERATOR = 'OR';

		// método dump obrigatório para retornar sempre strings
		abstract public function dump();
	}
?>