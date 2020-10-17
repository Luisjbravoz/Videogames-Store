<?php

/*
 * PROJECT: VIDEO GAME STORE.
 * LUIS J. BRAVO ZÚÑIGA.
 * MANAGER USER.
 */


 class ManagerUser {

    private static $INSTANCE = null;
    private const LOGIN = "call p_check_login(?,?);";

    private function ManagerUser() {
    }

    public static function getInstance(): self {
        if(self::$INSTANCE === null) {
            self::$INSTANCE = new ManagerUser();
        }
        return self::$INSTANCE;
    }

    public function check(string $username, string $password): bool {
        $output = 0;
        $conexion = ManagerConexionDB::getInstance()->connect();
        $pstmt = $result = null;
        try {
            $pstmt = $conexion->prepare(self::LOGIN);
            $pstmt->bind_param("ss", $username, $password); 
            if($pstmt->execute()) {
                $result = $pstmt->get_result();
                $output = $result->fetch_row()[0];
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
        return $output === 1;
    }

 } //END CLASS

 ?>