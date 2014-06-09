<?php

namespace Aggressiveswallow\Helpers;

use Aggressiveswallow\Models\Product;

/**
 * Holds the cart data
 *
 * @author Patrick
 */
class Cart {

    const SESSION_NAME = "cart";

    private $items;

    function __construct() {
        $this->items = array();
    }

    /**
     * Add a product to the cart
     * 
     * @param \Aggressiveswallow\Models\Product $product
     * @throws \Exception When not a valid product was given or a product is added twice.
     */
    public function add(Product $product) {
        $id = $product->getId();
        if ($id == null) {
            throw new \Exception("Product Id was not set. Not a valid product to be added to the cart.");
        }

        if ($this->has($product)) {
            throw new \Exception("Can not add the same product to the cart twice.");
        }

        $this->items[$id] = $product;
    }

    /**
     * Remove product from the cart
     * 
     * @param \Aggressiveswallow\Models\Product $product
     */
    public function remove(Product $product) {
        if ($this->has($product)) {
            unset($this->items[$product->getId()]);
        }
    }

    /**
     * Check if the cart already has a product
     * 
     * @param \Aggressiveswallow\Models\Product $product
     * @return boolean
     */
    public function has(Product $product) {
        return isset($this->items[$product->getId()]);
    }

    /**
     * Get the total price in whole euro's
     * @return int
     */
    public function getTotalPrice() {
        $total = 0;
        foreach ($this->items as $item) {
            /* @var $item \Aggressiveswallow\Models\Product */
            $total += $item->getPrice();
        }

        return (int) $total;
    }

    /**
     * Get the total price as a formatted string
     * 
     * @return string
     */
    public function getFormattedTotalPrice() {
        $format = "&euro; %s,-";
        return sprintf($format, number_format($this->getTotalPrice(), 0, ",", "."));
    }

    /**
     * Get all the products from the cart.
     * 
     * @return \Aggressiveswallow\Models\Product[]
     */
    public function getItems() {
        return $this->items;
    }

    /**
     * Get the amount of items in the cart.
     * 
     * @return int
     */
    public function itemCount() {
        return count($this->items);
    }
    
    public function destroy(){
        $this->items = array();
    }
    
    public function isEmpty() {
        return $this->itemCount() < 1;
    }
}
