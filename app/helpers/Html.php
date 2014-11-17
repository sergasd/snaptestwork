<?php

namespace TestWork\helpers;


class Html
{

    public static function encode($string)
    {
        $string = (string) $string;
        return htmlspecialchars($string, ENT_QUOTES, 'utf-8');
    }

} 