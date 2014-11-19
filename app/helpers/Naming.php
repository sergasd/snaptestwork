<?php

namespace TestWork\helpers;


class Naming
{

    public static function toCamelCase($underscoredName)
    {
        return preg_replace_callback('~_(\w)~', function($matches){
            return mb_strtoupper($matches[1]);
        }, $underscoredName);
    }

} 