<?php

namespace Aggressiveswallow\Models;

/**
 * Holds hierarchical data for in the database.
 *
 * @author Patrick
 */
class Tree
        extends BaseEntity {

    /**
     *
     * @var int id of the left
     */
    private $lft;

    /**
     *
     * @var int id of the right
     */
    private $rgt;

    public function isValid() {
        return true;
    }

    /**
     * 
     * @return int
     */
    public function getLft() {
        return $this->lft;
    }

    /**
     * 
     * @return int
     */
    public function getRgt() {
        return $this->rgt;
    }

    /**
     * 
     * @param int $lft
     */
    public function setLft($lft) {
        $this->lft = $lft;
    }

    /**
     *
     * @param int $rgt
     */
    public function setRgt($rgt) {
        $this->rgt = $rgt;
    }

    /**
     * Set the `lft` and `rgt` fields based on the parent.
     * @param \Aggressiveswallow\Models\Aggressiveswallow\Models\Tree $parent
     */
    public function setParent(Tree $parent) {
        $this->lft = $parent->getLft() + 1;
        $this->rgt = $parent->getLft() + 2;
    }

}
