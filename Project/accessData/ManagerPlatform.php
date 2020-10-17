<?php

/*
 * PROJECT: VIDEO GAME STORE.
 * LUIS J. BRAVO ZÚÑIGA.
 * MANAGER PLATFORM.
 */


class ManagerPlatform {

    private static $INSTANCE = null;                            //self
    private const LIST_PLATFORM = "call p_list_platform();";

    private function ManagerGenre() {
    }

    public static function getInstance(): self {
        if(self::$INSTANCE === null) {
            self::$INSTANCE = new ManagerPlatform();
        }
        return self::$INSTANCE;
    }

    public function list() {
        $conexion = ManagerConexionDB::getInstance()->connect();
        $pstmt = $result = null;
        $output = array();
        try {
            $pstmt = $conexion->prepare(self::LIST_PLATFORM);
            if($pstmt->execute()) {
                $result = $pstmt->get_result();
                while($result_data = $result->fetch_row()) {
                     $output[] = $result_data[0];
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