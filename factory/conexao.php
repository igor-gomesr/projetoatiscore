<?php
    class Caminho{
        public static $usuario = "administrador_projetoatiscore";
        public static $senha = "atiscore!";
        private static $connect = null;
        
        private static function Conectar()
        {
             try {
                if(self::$connect == null)
                {
                 self::$connect = new PDO(
                'mysql: host=localhost;
                 dbname=administrador_projetoatiscore;',self::$usuario,self::$senha
                );
                }
             } catch (Exception $ex) {
                echo 'Mensagem:'.$ex->getMessage();
                die;
             }
             return self::$connect; 
        }
        public function getConn()
        {
            return self::Conectar();
        }
    }
?>