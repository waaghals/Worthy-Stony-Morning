<?php

namespace Aggressiveswallow\Tools;

use Symfony\Component\HttpFoundation\Response;

/**
 * Splits the uri and calls the correct controller and action
 *
 * @author Patrick
 */
class Router
{

    private $autoloader;

    /**
     * Match the request data agains a controller and invoke the action
     * @param Request $req
     * @return Response A response object with correct status code.
     *
     * @throws Exception If the controller is invalid.
     */
    public function handle($req)
    {
        if (!is_a($req, "Aggressiveswallow\Tools\Request")) {
            throw new \InvalidArgumentException("Router::Match did not receive a valid request object");
        }

        $controllerPath = sprintf("WorthyStonyMorning\Controllers\%s",
                                  $req->getController());
        if (!$this->autoloader->classExists($controllerPath)) {
            $msg = sprintf("Controller \"%s\" bestaat niet.",
                           $req->getController());

            $t          = new Template("errors/Fatal");
            $t->message = $msg;
            $t->code    = Response::HTTP_NOT_FOUND;
            $t->type    = Response::$statusTexts[$t->code];

            return new Response($t, $t->code);
        }

        $ref = new \ReflectionClass($controllerPath);

        if (!$ref->isSubclassOf("\Aggressiveswallow\Controllers\BaseController")) {
            $msg = sprintf("Controller \"%s\" isn't a valid controller.",
                           $req->getController());
            throw new \Exception($msg);
        }

        $controller = $ref->newInstance();
        return $controller->callAction($req->getAction(), $req->getArguments());
    }

    public function getAutoloader()
    {
        return $this->autoloader;
    }

    public function setAutoloader($autoloader)
    {
        $this->autoloader = $autoloader;
    }

}
