<?php

/*
 * PROJECT: VIDEO GAME STORE.
 * LUIS J. BRAVO ZÚÑIGA.
 * FORMAT CLASS.
 */

class Format {

    private const FORMAT_OUTPUT_OBJECT = "%s: %s </br>";

    private const FORMAT_OUTPUT_JSON = "%s : %s ";

    private const FORMAT_OUTPUT_EXCEPTION = "<p style=\"color: red; font-weight: bold;\">Error: %s in line %s of file %s.</p>";

    private const FORMAT_OUTPUT_ARRAY = "</br>%s</br>";

    public static function GET_FORMAT_OUTPUT_OBJECT(): string {
        return self::FORMAT_OUTPUT_OBJECT;
    }

    public static function GET_FORMAT_OUTPUT_JSON(): string {
        return self::FORMAT_OUTPUT_JSON;
    }

    public static function GET_FORMAT_OUTPUT_EXCEPTION(): string {
        return self::FORMAT_OUTPUT_EXCEPTION;
    }

    public static function FORMAT_OUTPUT_LIST($array): string {
        $output = "";
        foreach($array as $item) {
            $output.= sprintf(self::FORMAT_OUTPUT_ARRAY, $item);
        }
        return $output;
    }

    public static function FORMAT_OUTPUT_BOOLEAN(bool $var): string {
        return $var ? "TRUE" : "FALSE";
    }

} //END CLASS

?>