<?php

namespace Aggressiveswallow\Helpers;

use Aggressiveswallow\Models\Location;

/**
 * Helpers for creating buttons
 *
 * @author Patrick
 */
class buttonHelper {

    public static function addToCart(Location $location, Cart $cart) {
        $link = "/cart/add/locationId=%s/";
        $button = "<a href=\"%s\" class=\"btn btn-primary ajax-reload\" %s>%s</a>";
        if (!is_null($cart)) {
            if ($cart->has($location)) {
                return \sprintf($button, "#", "disabled=\"disabled\"", "In winkelwagen");
            }
        }
        $uri = sprintf($link, $location->getId());
        return \sprintf($button, $uri, "", "<span class=\"glyphicon glyphicon-shopping-cart\"></span> Kopen");
    }

    public static function energyLabel($l) {
        $span = "<span class=\"label label-%s\">%s</span>";
        switch ($l) {
            case "a":
                return sprintf($span, "success", "A");
            case "b":
                return sprintf($span, "info", "B");
            case "c":
                return sprintf($span, "warning", "C");
            case "d":
                return sprintf($span, "danger", "D");
        }
    }

}
