<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace WorthyStonyMorning\Helpers;

use Aggressiveswallow\Tools\Template;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of MessageHelper
 *
 * @author Waaghals
 */
class MessageHelper
{

    public static function success($title, $subtitle, $desc)
    {
        $t        = self::create($title, $subtitle, $desc);
        $t->class = "success";
        return new Response($t);
    }

    public static function error($title, $subtitle, $desc)
    {
        $t        = self::create($title, $subtitle, $desc);
        $t->class = "error";
        return new Response($t);
    }

    private static function create($title, $subtitle, $desc)
    {
        $t               = new Template("common\message");
        $t->pageTitle    = ucfirst($title) . " " . strtolower($subtitle);
        $t->title        = ucfirst($title);
        $t->shortMessage = strtolower($subtitle);
        $t->description  = $desc;
        return $t;
    }

}
