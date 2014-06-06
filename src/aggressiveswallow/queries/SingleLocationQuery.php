<?php

namespace Aggressiveswallow\Queries;

use Aggressiveswallow\ResultQueryInterface;
use Aggressiveswallow\Factories\LocationFactory;

/**
 * Query a single location.
 *
 * @author Patrick
 */
class SingleLocationQuery
        extends BaseQuery
        implements ResultQueryInterface {

    /**
     *
     * @var int
     */
    private $id;

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

        if (!isset($this->id)) {
            throw new \Exception("Id not set.");
        }
        $sql = file_get_contents(VENDOR_PATH . "queries/sqlfiles/SingleLocation.sql");
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array("id" => $this->id));

        if ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            return $this->factory->create($row);
        } return null;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

}
