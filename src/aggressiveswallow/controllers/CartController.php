<?php

namespace Aggressiveswallow\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Aggressiveswallow\Tools\Container;
use Aggressiveswallow\Helpers\Cart;
use Aggressiveswallow\Helpers\AjaxResponses\CartMessage;
use Aggressiveswallow\Tools\Responses\JsonResponse;
use Aggressiveswallow\Tools\Template;
use Aggressiveswallow\Tools\Responses\ErrorResponse;
use Aggressiveswallow\Models\Order;
use Aggressiveswallow\Models\User;

/**
 * Simple cart controller for adding and removing products from the cart
 *
 * @author Patrick
 */
class CartController
        extends BaseController {

    /**
     *
     * @var \Aggressiveswallow\Helpers\Cart
     */
    private $cart;

    /**
     *
     * @var \Aggressiveswallow\Repositories\BaseRepository; 
     */
    private $repo;

    /**
     *
     * @var \Aggressiveswallow\Queries\SingleLocationQuery;
     */
    private $locationQuery;

    public function __construct() {
        parent::__construct();
        $this->repo = Container::make("genericRepository");
        $this->locationQuery = Container::make("singleLocationQuery");
    }

    public function showAction() {
        $t = new Template("cartViews/overview");
        $t->cart = $this->session->cart;

        return new Response($t);
    }

    public function addAction($locationId) {
        $responseObj = new CartMessage();
        $location = $this->getLocation($locationId);
        if ($this->session->cart->has($location)) {
            $responseObj->setHasError(true);
            $responseObj->setMessage("U heeft dit item al in de winkelwagen.");

            return new JsonResponse($responseObj);
        }

        $this->session->cart->add($location);
        $m = "%s is toegevoegd aan uw reacties.";
        $responseObj->setMessage(\sprintf($m, $location->getAddress()->getFullStreetName()));

        return new JsonResponse($responseObj);
    }

    public function removeAction($locationId) {
        $responseObj = new CartMessage();
        $location = $this->getLocation($locationId);
        if (!$this->session->cart->has($location)) {
            $responseObj->setHasError(true);
            $responseObj->setMessage("Het product om te verwijderen bestaat is niet in uw winkelwagen.");
            return new JsonResponse($responseObj);
        }

        $this->session->cart->remove($location);
        $m = "%s is verwijderd uit uw reactie lijst.";
        $responseObj->setMessage(sprintf($m, $location->getAddress()->getFullStreetName()));
        return new JsonResponse($responseObj);
    }

    private function getLocation($locationId) {
        $id = intval($locationId);
        if ($id < 1) {
            throw new \Exception("Not a valid \$locationId was given.");
        }

        $this->locationQuery->setId($locationId);
        $location = $this->repo->read($this->locationQuery);

        if (is_null($location)) {
            throw new \Exception(sprinf("No location exists with id %s", $id));
        }

        return $location;
    }

    public function debugAction() {
        $reponse = sprintf("<pre>%s</pre>", print_r($this->cart->getItems(), true));
        return new Response($reponse);
    }

}
