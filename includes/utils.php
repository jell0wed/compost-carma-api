<?php namespace CarmaAPI\utils;

class CarmaAPIUtils {
    public static function extractParameter($_params, $_key, $_default_value = null) {
        if(!isset($_params[$_key]) || is_null($_params[$_key])) {
            return $_default_value;
        }

        else return $_params[$_key];
    }
}