<?php

require 'bootstrapping.inc.php';

use Aggressiveswallow\Tools\Request;
use Aggressiveswallow\Tools\Router;
use Aggressiveswallow\Tools\Template;
use Symfony\Component\HttpFoundation\Response;

//Perform the router magic, call the correct controller and action
//based on the uri
try {
    $request = new Request();
    $router  = new Router();
    $router->setAutoloader($loader);

    $response = $router->handle($request);
    $response->send();
} catch (Exception $e) {
    $nav  = new Template("errors/Fatal");
    $body = "Message: %s<br />Line: %s<br />File: %s<br /><br />";
    $msg  = sprintf($body, $e->getMessage(), $e->getLine(), $e->getFile());
    $msg .= str_repeat(">", 15);
    $msg .= " Trace ";
    $msg .= str_repeat(">", 15);
    $msg .= "<br />";

    $i = 0;
    foreach ($e->getTrace() as $trace) {
        $msg .= sprintf("%s. <strong>%s</strong>::%s <i>(%s)</i><br />", $i,
                        @$trace["class"], @$trace["function"], @$trace["line"]);
        $i++;
    }
    $nav->message = $msg;
    $nav->code    = Response::HTTP_INTERNAL_SERVER_ERROR;
    $nav->type    = Response::$statusTexts[$nav->code];

    $response = new Response($nav, $nav->code);
    $response->send();
}