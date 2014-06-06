<?php

namespace Aggressiveswallow\Models;

use Aggressiveswallow\Models\Location;
use Aggressiveswallow\Models\User;

/**
 * A order has all the items the user bought.
 *
 * @author Patrick
 */
class Order
        extends BaseEntity {

    /**
     * The locations/products the user bought.
     * 
     * @var \Aggressiveswallow\Models\Location[]
     * @virtual
     */
    private $locations;

    /**
     * User who bought the items in this order.
     * 
     * @var \Aggressiveswallow\Models\User
     */
    private $user;

    /**
     * If the order has been handled e.g. keys have been exchanged.
     * 
     * @var boolean
     */
    private $completed;

    public function __construct() {
        $this->locations = array();
        $this->completed = false;
    }

    /**
     * 
     * @return \Aggressiveswallow\Models\Location[]
     */
    public function getLocations() {
        return $this->locations;
    }

    /**
     * 
     * @return \Aggressiveswallow\Models\User
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * 
     * @return boolean True if the order has been completed.
     */
    public function getCompleted() {
        return $this->completed;
    }

    /**
     * 
     * @param \Aggressiveswallow\Models\Location $locations
     */
    public function setLocations(Location $locations) {
        $this->locations = $locations;
    }

    /**
     * 
     * @param \Aggressiveswallow\Models\User $user
     */
    public function setUser(User $user) {
        $this->user = $user;
    }

    /**
     * 
     * @param boolean $completed True if the order has been completed.
     */
    public function setCompleted($completed) {
        $this->completed = $completed;
    }

    public function addLocation(Location $location) {
        if (!$this->hasLocation($location)) {
            $this->locations[] = $location;
        }
    }

    public function hasLocation(Location $location) {
        return \in_array($location, $this->locations);
    }

}
