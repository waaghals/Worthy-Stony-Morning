<?php

namespace Aggressiveswallow\Factories;

use Aggressiveswallow\FactoryInterface;
use Aggressiveswallow\Models\Address;

/**
 * Description of AddressFactory
 *
 * @author Patrick
 */
class AddressFactory
        implements FactoryInterface {

    public function create($data) {
        $address = new Address();
        if(isset($data["address_id"])){
            $address->setId(intval($data["address_id"]));
        }

        $address->setStreet($data["address_street"]);
        $address->setCity($data["address_city"]);
        $address->setZipcode($data["address_zipcode"]);
        $address->setHouseNumber($data["address_housenumber"]);
        $address->setNeighborhood($data["address_neighborhood"]);
        
        return $address;
    }

}
