<?php

final class AES256Util
{

    public function __construct()
    {
    }

    /**
     * Шифрует/дешифрует строку текста
     * 
     * @param String $action  - 'encrypt' || 'decrypt'
     * @param String $string  - входящая строка
     * @param String $public  - откртый ключ
     * @param String $private - вектор
     *
     * @return String
     */
    public function encrypt_decrypt( $action, $string, $public, $private )
    {
        $output         = false;
        $encrypt_method = "AES-256-CBC";

        // hash
        $key = hash('sha256', $public);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $private), 0, 16);
        if ( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

    /**
     * Шифрует строку
     * 
     * @param String $text
     * @param String $public  - открытый ключ
     * @param String $private - вектор
     * 
     * @return String
    */
    public function encrypt( $text, $public, $private )
    {
        return $this->encrypt_decrypt( 'encrypt', $text, $public, $private );
    }

    /**
     * Шифрует строку
     * 
     * @param String $text
     * @param String $public  - открытый ключ
     * @param String $private - вектор
     * 
     * @return String
    */
    public function decrypt( $text, $public, $private )
    {
        return $this->encrypt_decrypt( 'decrypt', $text, $public, $private );
    }

};
