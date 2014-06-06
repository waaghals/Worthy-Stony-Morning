<?php

namespace Aggressiveswallow\Queries;

use Aggressiveswallow\ResultQueryInterface;
use Aggressiveswallow\Factories\LocationFactory;

/**
 * Query the latest locations.
 *
 * @author Patrick
 */
class LatestLocationQuery
        extends BaseQuery
        implements ResultQueryInterface {

    /**
     *
     * @var \Aggressiveswallow\Factories\LocationFactory
     */
    private $factory;
    
    public function __construct(\PDO $connection, LocationFactory $f) {
        parent::__construct($connection);
        $this->factory = $f;
    }

    public function fetch() {

        $sql = file_get_contents(BASE_PATH . "src/aggressiveswallow/queries/sqlfiles/LatestLocations.sql");
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $locations = array();
        foreach($rows as $row){
            $locations[] = $this->factory->create($row);
        }
        return $locations;
    }

}
