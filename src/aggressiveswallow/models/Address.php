<?php

namespace Aggressiveswallow\Models;

/**
 * A address for a location.
 *
 * @author Patrick
 */
class Address
        extends BaseEntity {

    /**
     *
     * @var string Street name of object
     */
    private $street;

    /**
     *
     * @var string House number including the additive
     */
    private $houseNumber;

    /**
     *
     * @var string Name of the city or village.
     */
    private $city;

    /**
     *
     * @var string The zipcode for the location
     */
    private $zipcode;
    
    /**
     *
     * @var string
     */
    private $neighborhood;

    public function getStreet() {
        return $this->street;
    }

    public function getHouseNumber() {
        return $this->houseNumber;
    }

    public function getCity() {
        return $this->city;
    }

    public function getZipcode() {
        return $this->zipcode;
    }

    public function setStreet($street) {
        $this->street = $street;
    }

    public function setHouseNumber($houseNumber) {
        $this->houseNumber = $houseNumber;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function setZipcode($zipcode) {
        $this->zipcode = $zipcode;
    }

    public function getFullStreetName() {
        return $this->street . " " . $this->houseNumber;
    }

    public function isValid() {
        return true;
    }
    
    public function getNeighborhood() {
        return $this->neighborhood;
    }

    public function setNeighborhood($neighbourhood) {
        $this->neighborhood = $neighbourhood;
    }



}
