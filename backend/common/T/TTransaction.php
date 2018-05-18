<?php
	namespace T;
	// classe de transação
	final class TTransaction{
		private static $conn; // conexão ativa
		private static $logger; // objeto de LOG

		private function __construct(){}

		public static function open($database){
			//abre uma conexão e armazena na propriedade estática $conn
			if(empty(self::$conn)){
				self::$conn = TConnection::open($database);
				//inicia a transação
				self::$conn->beginTransaction();
				self::$logger = NULL;
			}
		}

		//método get() retorna a conexão ativa da transação
		public static function get(){
			return self::$conn;
		}

		//método rollback() desfaz todas operações realizadas na transação
		public static function rollback(){
			if(self::$conn){
				self::$conn->rollback();
				self::$conn = NULL;
			}
		}

		//método close() aplica todas as operações realizadas e fecha a transação
		public static function close(){
			if(self::$conn){
				self::$conn->commit();
				self::$conn = NULL;
			}
		}

		// método setLogger() define qual estrategia (algoritmo de LOG será usado)
		public static function setLogger(TLogger $logger){
			self::$logger = $logger;
		}

		// armazena uma mensagem no arquivo de log baseada na estratégia ($logger) atual

		public static function log($message){
			if(self::$logger){
				self::$logger->write($message);
			}
		}
	}
?>