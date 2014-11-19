<?php

namespace TestWork\helpers;


class Date
{

    public static function dateToHuman($dbDate)
    {
        try {
            $date = new \DateTime($dbDate);
            return $date->format('d.m.Y');
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function dateToDatabase($humanDate)
    {
        try {
            $date = new \DateTime($humanDate);
            return $date->format('Y-m-d');
        } catch (\Exception $e) {
            return false;
        }
    }

} 