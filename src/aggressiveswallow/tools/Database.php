<?php

namespace Aggressiveswallow\Tools;

/**
 * Databasew wrapper class. Creates a singleton for \PDO
 *
 * @author Patrick
 */
class Database
        extends \PDO {

    public function &instance($dsn, $username = null, $password = null, $driver_options = null) {
        static $instance = null;
        if ($instance === null) {
            $instance = new self($dsn, $username, $password, $driver_options);
        }
        
        return $instance;
    }

}
