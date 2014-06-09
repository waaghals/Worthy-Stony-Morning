<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Aggressiveswallow\Queries;

/**
 * Get the full tree from the database
 *
 * @author Patrick
 */
class TreeLimitsQuery
        extends BaseQuery {

    public function fetch() {

        $this->addField("MIN(`lft`) AS `min`");
        $this->addField("MAX(`rgt`) AS `max`");
        
        
        $selectFields = implode(", ", $this->fields);
        $sql = sprintf("SELECT %s FROM `%s`", $selectFields, $this->table);
        $stmt = $this->connection->prepare($sql);

        $stmt->execute();

        $stmt->setFetchMode(\PDO::FETCH_CLASS, $this->className);
        return $stmt->fetch();
    }

}
