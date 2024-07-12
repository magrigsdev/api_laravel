<?php

namespace App\Utilities;

class MyMessage {
    public static function  data_empty(string $message = null):string{
        return $message . " is empty";
    }
    public static function status(bool $etat = false): bool
    {
        return $etat ;
    }
    public static function data_no_exist(string $message = null): mixed
    {
         return $message . " not exist";
    }

    public static function value_empty(string $message = null): mixed
    {
        return $message . " the value is empty"; 
    }
    public static function data_incorrect(string $message = null): mixed
    {
        return $message . " error data incorrect";
    }
    public static function data_no_found(string $message = null): mixed
    {
        return $message . " no data found";
    }
    public static function data_saved(string $message = null): mixed
    {
        return $message . " data saved";
    }
    public static function data_already_exist(string $datum = null): mixed
    {
        return $datum . "  already exist";
    }
    public static function data_info(string $info): mixed
    {
        return "  data is " . $info;
    }
}