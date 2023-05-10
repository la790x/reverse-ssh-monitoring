<?php

namespace App\Helpers;

class StringHelper
{
    /**
     * check string is json
     *
     * @param  string  $str
     * @return bool
     */
    public function isJson($str)
    {
        return is_string($str) && is_array(json_decode($str, true)) ? true : false;
    }

    /**
     * change null with dash
     *
     * @param  string  $str
     * @return string
     */
    public function changeNullWithDash($str)
    {
        return (is_null($str)) ? '-' : $str;
    }
}
