<?php

namespace WorthyStonyMorning\Helpers;

class ValidatorHelper
{

    public static function htmlValidtor()
    {
        if ($_SERVER["SERVER_PORT"] != "80") {
            $url = $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $url = $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }

        return "http://validator.w3.org/check?uri=" . $url . "&charset=%28detect+automatically%29&doctype=Inline&group=0";
    }

}
