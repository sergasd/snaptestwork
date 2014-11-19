<?php

namespace TestWork\helpers;


class Validator
{

    public static function validateRequired($value, &$options = [])
    {
        if (0 === mb_strlen($value)) {
            if (empty($options['message'])) {
                $options['message'] = "{$options['attribute']} is required";
            }
            return false;
        }

        return true;
    }

    public static function validateNumber($value, &$options = [])
    {
        if (!is_numeric($value)) {
            if (empty($options['message'])) {
                $options['message'] = "{$options['attribute']} is not number";
            }
            return false;
        }

        return true;
    }

} 