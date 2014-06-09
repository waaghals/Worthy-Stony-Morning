<?php

namespace Aggressiveswallow\Queries\Treequeries;

use Aggressiveswallow\RunQueryInterface;
use Aggressiveswallow\Queries\Treequeries\TreeQuery;

/**
 * Add 2 from the `lft` or `rgt` fields from the hierachy table
 *
 * @author Patrick
 */
class AddQuery
        extends TreeQuery
        implements RunQueryInterface {

    const LEFT = "UPDATE `tree` SET `lft` = `lft` + 2 WHERE `lft` > :left";
    const RIGHT = "UPDATE `tree` SET `rgt` = `rgt` + 2 WHERE `rgt` > :left";

    private $left;

    /**
     * Add 2 from every node where the fieldname is larger than the supplied id;
     */
    public function run() {
        $stmtLft = $this->connection->prepare(AddQuery::LEFT);
        $stmtRgt = $this->connection->prepare(AddQuery::RIGHT);
        $stmtLft->execute(array("left" => $this->left));
        $stmtRgt->execute(array("left" => $this->left));
    }

    public function setLeft($left) {
        $this->left = $left;
    }

}
