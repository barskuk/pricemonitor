<?php

class GeneralChecks
{
    public static function isUrl($url) {

        //Помните, что URL не содержащий имя протокола http:// является корректный, так что может потребоваться дополнительная проверка того,
        // что URL использует требуемый протокол, например ssh:// или mailto:.
        // Обратите внимание, что эта функция считает корректными только URL, состоящие из символов ASCII;
        // Интернациональные доменные имена не пройдут проверку.
        if (filter_var($url, FILTER_VALIDATE_URL)) {

            return TRUE;
        }
        return FALSE;

    }

    public static function getHttpResponseCode($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $data = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $httpcode;
    }

    public static function parseHost($url) {
        return parse_url($url, PHP_URL_HOST);
    }

}