<?php

namespace Aggressiveswallow\Models;

use Aggressiveswallow\Models\MenuItem;
use Aggressiveswallow\Models\Order;

/**
 * Basic items of a product
 *
 * @author Patrick
 */
class Location
        extends Product {

    /**
     *
     * @var Aggressiveswallow\Models\MenuItem
     */
    private $menuItem;

    /**
     *
     * @var Aggressiveswallow\Models\Address 
     */
    private $address;

    /**
     *
     * @var string 
     */
    private $energyLabel;

    /**
     *
     * @var int
     */
    private $area;

    /**
     *
     * @var int
     */
    private $yardArea;

    /**
     *
     * @var boolean
     */
    private $newBuild;

    /**
     *
     * @var \Aggressiveswallow\Models\Order
     */
    private $order;

    /**
     *
     * @var string
     */
    private $foto;

    /**
     * 
     * @return Aggressiveswallow\Models\MenuItem
     */
    public function getMenuItem() {
        return $this->menuItem;
    }

    /**
     * 
     * @return \Aggressiveswallow\Models\Address 
     */
    public function getAddress() {
        return $this->address;
    }

    /**
     * 
     * @param \Aggressiveswallow\Models\MenuItem $category
     */
    public function setMenuItem(MenuItem $category) {
        $this->menuItem = $category;
    }

    /**
     * 
     * @param \Aggressiveswallow\Models\Address $address
     */
    public function setAddress(Address $address) {
        $this->address = $address;
    }

    public function getEnergyLabel() {
        return $this->energyLabel;
    }

    public function getFoto() {
        return $this->foto;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
    }

    public function setEnergyLabel($energyLabel) {
        $validLabels = array("a", "b", "c", "d");
        if (!in_array($energyLabel, $validLabels)) {
            $m = "Not a valid label passed to setEnergyLabel. Instead %s was given.";

            throw new \Exception(sprintf($m, $energyLabel));
        }
        $this->energyLabel = $energyLabel;
    }

    public function getArea() {
        return intval($this->area);
    }

    public function getYardArea() {
        return intval($this->yardArea);
    }

    public function setArea($area) {
        $this->area = $area;
    }

    public function setYardArea($yardArea) {
        $this->yardArea = $yardArea;
    }

    public function getNewBuild() {
        return (bool) $this->newBuild;
    }

    public function setNewBuild($newBuild) {
        $this->newBuild = $newBuild;
    }

    public function getOrder() {
        return $this->order;
    }

    public function setOrder(Order $order) {
        $this->order = $order;
    }

}
