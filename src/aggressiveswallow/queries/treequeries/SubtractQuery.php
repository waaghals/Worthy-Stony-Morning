<?php

namespace Aggressiveswallow\Queries\Treequeries;

use Aggressiveswallow\RunQueryInterface;

/**
 * Subtract 2 from the `lft` or `rgt` fields from the hierachy table
 *
 * @author Patrick
 */
class SubtractQuery
        extends TreeQuery
        implements RunQueryInterface {

    const LEFT = "UPDATE `tree` SET `lft` = `lft` - :width WHERE `lft` > :right";
    const RIGHT = "UPDATE `tree` SET `rgt` = `rgt` - :width WHERE `rgt` > :right";

    private $right;
    private $left;

    /**
     * Subtract 2 from every node where the fieldname is larger than the supplied id;
     */
    public function run() {
        if ($this->right == null || $this->left == null) {
            throw new Exception("Left or Right fields not set.");
        }
        $width = $this->right - $this->left + 1;

        $stmtLft = $this->connection->prepare(SubtractQuery::LEFT);
        $stmtRgt = $this->connection->prepare(SubtractQuery::RIGHT);
        $stmtLft->execute(array("width" => $width, "right" => $this->right));
        $stmtRgt->execute(array("width" => $width, "right" => $this->right));
    }

    public function setRight($right) {
        $this->right = $right;
    }

    public function setLeft($left) {
        $this->left = $left;
    }

}
