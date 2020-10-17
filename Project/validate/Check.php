<?php

/*
 * PROJECT: VIDEO GAME STORE.
 * LUIS J. BRAVO ZÚÑIGA.
 * CHECK CLASS.
 */

 class Check {

    public static function VALIDATE_EMAIL_ADDRESS(string $data): bool {
        return filter_var($data, FILTER_VALIDATE_EMAIL);
     
    }
    
    public static function VALIDATE_ONLY_NUMBERS(string $data): bool {
        return ctype_digit($data);
    }

    public static function VALIDATE_ONLY_LETTERS(string $data): bool {
        return ctype_alpha($data);

    }

    public static function VALIDATE_PASSWORD(string $data): bool {
        return preg_match("^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$^", $data);
    }

 } // END CLASS
?>