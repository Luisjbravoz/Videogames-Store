<?php

/*
 * PROJECT: VIDEO GAME STORE.
 * LUIS J. BRAVO ZÚÑIGA.
 * MANAGER VIDEOGAME.
 */


class ManagerVideogame {

    private static $INSTANCE = null;
    private const INSERT_VIDEOGAME = "call p_insert_videogame(?,?,?,?,?);",
                  UPDATE_VIDEOGAME = "call p_update_videogame(?,?,?,?,?,?);",
                  DELETE_VIDEOGAME = "call p_delete_videogame(?);",
                  CONSULT_VIDEOGAME = "call p_consult_videogame(?);",
                  LIST_VIDEOGAME = "call p_list_videogame();";

    private function ManagerVideogame() {
    }

    public static function getInstance(): self {
        if(self::$INSTANCE === null) {
            self::$INSTANCE = new ManagerVideogame();
        }
        return self::$INSTANCE;
    }

    public function insert(Videogame $object): bool {
        $aux_title = $object->getTitle();
        $aux_idPlatform = $object->getIdPlatform();
        $aux_idGenre = $object->getIdGenre();
        $aux_price = $object->getPrice();
        $aux_quantity = $object->getQuantity();
        $output = false;
        $conexion = ManagerConexionDB::getInstance()->connect();
        $pstmt = null;
        try {
            $pstmt = $conexion->prepare(self::INSERT_VIDEOGAME);
            $pstmt->bind_param("siidi", $aux_title, $aux_idPlatform, $aux_idGenre, $aux_price, $aux_quantity);
            if($pstmt->execute()) {
                    $output = true;   
            } else {
                throw new MyException(MyException::GET_ERROR_OPERATION());
            }
        } catch(MyException | mysqli_sql_exception $ex) {
            MyException::SHOW_ERROR($ex);
        } finally {
            try {
                if($pstmt) {
                    $pstmt->close();
                }
                ManagerConexionDB::getInstance()->disconnect();
            } catch(mysqli_sql_exception $ex) {
                MyException::SHOW_ERROR($ex);
            }
        }
        return $output;
    }

    public function update(Videogame $object): bool {
        $aux_id = $object->getId();
        $aux_title = $object->getTitle();
        $aux_idPlatform = $object->getIdPlatform();
        $aux_idGenre = $object->getIdGenre();
        $aux_price = $object->getPrice();
        $aux_quantity = $object->getQuantity();
        $output = false;
        $conexion = ManagerConexionDB::getInstance()->connect();
        $pstmt = null;
        try {
            $pstmt = $conexion->prepare(self::UPDATE_VIDEOGAME);
            $pstmt->bind_param("isiidi",  $aux_id, $aux_title, $aux_idPlatform, $aux_idGenre, $aux_price, $aux_quantity);
            if($pstmt->execute()) {
                    $output = true;   
            } else {
                throw new MyException(MyException::GET_ERROR_OPERATION());
            }
        } catch(MyException | mysqli_sql_exception $ex) {
            MyException::SHOW_ERROR($ex);
        } finally {
            try {
                if($pstmt) {
                    $pstmt->close();
                }
                ManagerConexionDB::getInstance()->disconnect();
            } catch(mysqli_sql_exception $ex) {
                MyException::SHOW_ERROR($ex);
            }
        }
        return $output;
    }

    public function delete(int $id): bool {
        $output = false;
        $conexion = ManagerConexionDB::getInstance()->connect();
        $pstmt = null;
        try {
            $pstmt = $conexion->prepare(self::DELETE_VIDEOGAME);
            $pstmt->bind_param("i",  $id);
            if($pstmt->execute()) {
                    $output = true;   
            } else {
                throw new MyException(MyException::GET_ERROR_OPERATION());
            }
        } catch(MyException | mysqli_sql_exception $ex) {
            MyException::SHOW_ERROR($ex);
        } finally {
            try {
                if($pstmt) {
                    $pstmt->close();
                }
                ManagerConexionDB::getInstance()->disconnect();
            } catch(mysqli_sql_exception $ex) {
                MyException::SHOW_ERROR($ex);
            }
        }
        return $output;
    }

    public function consult(int $id): ?Videogame {
        $conexion = ManagerConexionDB::getInstance()->connect();
        $pstmt = $result = $output = null;
        try {
            $pstmt = $conexion->prepare(self::CONSULT_VIDEOGAME);
            $pstmt->bind_param("i",  $id);
            if($pstmt->execute()) {
                $result = $pstmt->get_result();
                $result_data = $result->fetch_row();
                if($result_data) {
                    $output = new Videogame($result_data[0],$result_data[1], $result_data[2], $result_data[3], $result_data[4], $result_data[5]);  
                } else {
                    throw new MyException(MyException::GET_ERROR_NO_DATA_FOUND());
                }
            } else {
                throw new MyException(MyException::GET_ERROR_OPERATION());
            }
        } catch(MyException | mysqli_sql_exception $ex) {
            MyException::SHOW_ERROR($ex);
        } finally {
            try {
                if($pstmt) {
                    $pstmt->close();
                }
                ManagerConexionDB::getInstance()->disconnect();
            } catch(mysqli_sql_exception $ex) {
                MyException::SHOW_ERROR($ex);
            }
        }
        return $output;
    }

    public function list() {
        $conexion = ManagerConexionDB::getInstance()->connect();
        $pstmt = $result = null;
        $output = array();
        try {
            $pstmt = $conexion->prepare(self::LIST_VIDEOGAME);
            if($pstmt->execute()) {
                $result = $pstmt->get_result();
                while($result_data = $result->fetch_row()) {
                     $output[] = new Videogame($result_data[0],$result_data[1], $result_data[2], $result_data[3], $result_data[4], $result_data[5]);
                }
                if(count($output) === 0) {
                    throw new MyException(MyException::GET_ERROR_NO_DATA_FOUND());
                }
            } else {
                throw new MyException(MyException::GET_ERROR_OPERATION());
            }
        } catch(MyException | mysqli_sql_exception $ex) {
            MyException::SHOW_ERROR($ex);
        } finally {
            try {
                if($pstmt) {
                    $pstmt->close();
                }
                ManagerConexionDB::getInstance()->disconnect();
            } catch(mysqli_sql_exception $ex) {
                MyException::SHOW_ERROR($ex);
            }
        }
        return $output;
    }

} //END CLASS

?>