<?php

namespace TestWork\helpers;


class Validator
{

    public static function validateRequired($value, &$options = [])
    {
        if (empty($value)) {
            if (empty($options['message'])) {
                $options['message'] = "{$options['attribute']} is required";
            }
            return false;
        }

        return true;
    }

} 