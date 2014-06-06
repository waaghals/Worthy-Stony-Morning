<?php

namespace Aggressiveswallow\Queries;

use Aggressiveswallow\Factories\MenuItemFactory;

/**
 * Get the full navigation tree
 *
 * @author Patrick
 */
class CategoriesQuery
        extends BaseQuery {

    /**
     *
     * @var \Aggressiveswallow\Factories\NavItemFactory 
     */
    private $factory;

    public function __construct(\PDO $connection, MenuItemFactory $factory) {
        parent::__construct($connection);
        $this->factory = $factory;
    }

    public function fetch() {

        $sql = file_get_contents(BASE_PATH . "src/aggressiveswallow/queries/sqlfiles/SelectNavigation.sql");
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        $categories = array();
        foreach($rows as $row){
            $categories[] = $this->factory->create($row);
        }
        
        return $categories;
    }

}
