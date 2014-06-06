<?php

namespace Aggressiveswallow\Queries;

use Aggressiveswallow\Factories\UserFactory;

/**
 * Get a single user by its name
 *
 * @author Patrick
 */
class UserByNameQuery extends BaseQuery
{

    private $name;
    private $factory;

    function __construct(\PDO $pdo, UserFactory $factory)
    {
        parent::__construct($pdo);
        $this->factory = $factory;
    }

    public function fetch()
    {
        if (!isset($this->name)) {
            throw new \Exception("Name not set");
        }
        $sql  = file_get_contents(SRC_PATH . "aggressiveswallow/queries/sqlfiles/SingleUserByName.sql");
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array("name" => $this->name));

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $this->factory->create($row);
    }

    public function setName($name)
    {
        $this->name = $name;
    }

}
