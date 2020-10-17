<?php

/*
 * PROJECT: VIDEO GAME STORE.
 * LUIS J. BRAVO ZÚÑIGA.
 * MY EXCEPTION CLASS.
 */


 class MyException extends Exception {

    private const ERROR_OPERATION = "an error ocurred, the operation was not completed",
                  ERROR_NO_DATA = "no data found",
                  ERROR_NULL_REFERENCE = "null reference",
                  ERROR_CONEXION_NOT_OPEN = "conexion is not open",
                  ERROR_NO_DATA_FOUND = "no data found";
                 

    public function MyException(string $message) {
        parent::__construct($message);
    }

    public static function SHOW_ERROR($ex) { 
        echo sprintf(Format::GET_FORMAT_OUTPUT_EXCEPTION(), $ex->getMessage(), $ex->getLine(), $ex->getFile());
        //echo $ex;
    }

    public static function GET_ERROR_OPERATION(): string {
        return self::ERROR_OPERATION;
    }

    public static function GET_ERROR_NO_DATA(): string {
        return self::ERROR_NO_DATA;
    }

    public static function GET_ERROR_NULL_REFERENCE(): string {
        return self::ERROR_NULL_REFERENCE;
    }

    public static function GET_ERROR_CONEXION_NOT_OPEN(): string {
        return self::ERROR_CONEXION_NOT_OPEN;
    }

    public static function GET_ERROR_NO_DATA_FOUND(): string {
        return self::ERROR_NO_DATA_FOUND;
    }

 } // END CLASS
?>