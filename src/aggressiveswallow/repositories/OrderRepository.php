<?php

namespace Aggressiveswallow\Repositories;

use Aggressiveswallow\Models\BaseEntity;

/**
 * Handles the creation of orders
 *
 * @author Patrick
 */
class OrderRepository
        extends GenericRepository {

    public function create(BaseEntity $object) {
        if (!is_a($object, "\Aggressiveswallow\Models\Order")) {
            $msg = "Not a valid `Order` object given. Instead type \"%s\" was given.";
            throw new \Exception(sprintf($msg, get_class($object)));
        }
        /* @var $object \Aggressiveswallow\Models\Order */
        foreach ($object->getLocations() as $loc) {
            parent::create($loc);
        }

        parent::create($object);
        return $object;
    }

    public function delete(BaseEntity $object) {
        /* @var $object \Aggressiveswallow\Models\Order */
        foreach ($object->getLocations() as $loc) {
            /* @var $loc \Aggressiveswallow\Models\Location */
            $loc->setOrder(null);
        }

        parent::delete($object);
    }

    public function update(BaseEntity $object) {
        parent::update($object);
    }

}
