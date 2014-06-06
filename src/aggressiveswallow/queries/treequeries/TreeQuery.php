<?php

namespace Aggressiveswallow\Queries\Treequeries;

/**
 * Description of TreeQuery
 *
 * @author Patrick
 */
abstract class TreeQuery {

    /**
     *
     * @var \PDO
     */
    protected $connection;

    public function __construct(\PDO $connection) {
        $this->connection = $connection;
    }

    public function setId($id) {
        $intval = intval($id);
        if (!is_int($intval)) {
            $m = sprintf("First agrument `id` in TreeQuery::setId should be an integer. Instead type `%s` was given.", gettype($id));
            throw new \Exception($m);
        }
        $this->id = $id;
    }

}
