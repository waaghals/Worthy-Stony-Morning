<?php

namespace Aggressiveswallow\Models;

/**
 * BaseEntity for all models, every model should have an id.
 *
 * @author Patrick
 */
abstract class BaseEntity {

    /**
     *
     * @var int Primairy field
     */
    protected $id;

    public function getId() {
        return $this->id;
    }

    /**
     * 
     * @param int $id
     * @throws \InvalidArgumentException when id is not an interger
     */
    public function setId($id) {
        if (!is_int($id)) {
            throw new \InvalidArgumentException("Not a valid Id was passed to setId on BaseEntity");
        }

        if ($this->id === $id) {
            return;
        }

        if (!$this->id == null) {
            throw new \Exception("Id can be set only once.");
        }

        $this->id = $id;
    }

    public function __toString() {
        return (string) $this->getId();
    }
}
