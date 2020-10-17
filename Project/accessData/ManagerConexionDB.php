<?php

/*
 * PROJECT: VIDEO GAME STORE.
 * LUIS J. BRAVO ZÚÑIGA.
 * MANAGER CONEXION BD.
 */

 class ManagerConexionDB {
    
    private static $INSTANCE = null;     
    private $conexion;                

    private function ManagerConexionDB() {
        $this->conexion = null;
    }

    public static function getInstance(): self {
        if(self::$INSTANCE === null) {
           self::$INSTANCE = new ManagerConexionDB();
        }
        return self::$INSTANCE;
    }

    public function connect() {
        try {
            $this->conexion = new mysqli("localhost", "root", "", "videogames_store");
        } catch(mysqli_sql_exception $ex) {
            MyException::SHOW_ERROR($ex);
        }
        return $this->conexion;
    }

    public function disconnect() {
        try {
            if($this->conexion) {
                $this->conexion->close();
            } else{
                throw new MyException(MyException::GET_ERROR_CONEXION_NOT_OPEN());
            }
        } catch(MyException $ex) {
            MyException::SHOW_ERROR($ex);
        }
    }

 } //END CLASS

?>