<?php

namespace Aggressiveswallow\Models;

/**
 * Description of Product
 *
 * @author Patrick
 */
class Product
        extends BaseEntity {

    /**
     *
     * @var string Description for the product
     */
    protected $description;

    /**
     *
     * @var int Price in cents 
     */
    protected $price;

    public function getDescription() {
        return $this->description;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function getFormattedPrice() {
        $format = "&euro; %s,-";
        return sprintf($format, number_format($this->price, 0, ",", "."));
    }

    public function isValid() {
        return ($this->price > 0) && (strlen($this->description) > 5);
    }

}
