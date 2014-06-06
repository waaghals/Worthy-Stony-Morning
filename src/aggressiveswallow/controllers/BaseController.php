<?php

namespace Aggressiveswallow\Controllers;

use Aggressiveswallow\Tools\Container;
use Aggressiveswallow\Tools\Responses\ErrorResponse;
use Symfony\Component\HttpFoundation\Response;
use Aggressiveswallow\Helpers\Cart;

/**
 * Description of baseController
 *
 * @author Patrick
 */
abstract class BaseController
{

    /**
     *
     * @var \Aggressiveswallow\Tools\Session
     */
    protected $session;

    public function __construct()
    {
        $this->session = Container::make("session");
    }

    /**
     * Call a controller action with named arguments.
     * @param string $actionName
     * @param array $arguments
     * @return mixed value of the called method
     */
    public function callAction($actionName, array $arguments = array())
    {
        try {
            $reflection = new \ReflectionMethod($this, $actionName);
        } catch (\Exception $e) {
            return new ErrorResponse(sprintf("Action \"%s\" does not exist.",
                                             $actionName),
                                             Response::HTTP_NOT_FOUND);
        }

        $pass = array();

        //Build the arguments array in the order of actual method arguments
        foreach ($reflection->getParameters() as $param) {
            $key = $param->getName();

            if (isset($arguments[$key])) {
                $pass[] = $arguments[$key];
            } else {
                $pass[] = $param->getDefaultValue();
            }
        }

        //Actually run the method/action
        $actionResponse = $reflection->invokeArgs($this, $pass);

        if (!is_a($actionResponse, "Symfony\Component\HttpFoundation\Response")) {
            $msg = sprintf("Did not receive a valid response from controller action: %s",
                           $actionName);
            throw new \Exception($msg);
        }

        return $actionResponse;
    }

    private function initCart()
    {
        $cart_name = Cart::SESSION_NAME;

        if (!$this->session->has($cart_name)) {
            $this->session->$cart_name = Container::make("cart");
        }
    }

}
