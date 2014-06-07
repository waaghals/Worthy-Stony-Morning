<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace WorthyStonyMorning\Helpers;

/**
 * Description of FormHelper
 *
 * @author Waaghals
 */
class FormHelper
{

    public static function val($data, $key)
    {
        if (\array_key_exists($key, $data)) {
            sprintf("value=\"%s\"" . $data[$key]);
        }
    }

}
