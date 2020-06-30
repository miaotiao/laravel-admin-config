<?php

use Illuminate\Support\Carbon;

if (!function_exists('dbConfig')) {
    function dbConfig($key = '')
    {
        $config = config('dbConfig');
        if (empty($key)) {
            return $config;
        }

        return $config[$key] ?? '';
    }
}

if (!function_exists('parse_config_attr')) {
    function parse_config_attr($string, $type)
    {
        if (empty($string)) {
            return $type === 4 ? [] : null;
        }

        switch ($type) {
            case 4:
                $attrArr = preg_split('/[,;\r\n]+/', trim($string, ",;\r\n"));
                if (strpos($string, ':')) {
                    $value = [];
                    foreach ($attrArr as $val) {
                        list($k, $v) = explode(':', $val);
                        $value[$k] = $v;
                    }
                } else {
                    $value = $attrArr;
                }
                break;

            case 6:
                $value = Carbon::parse($string);
                break;

            default:
                $value = $string;
                break;
        }

        return $value;
    }
}
