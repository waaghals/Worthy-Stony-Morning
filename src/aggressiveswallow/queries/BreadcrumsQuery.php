<?php

namespace Aggressiveswallow\Queries;

use Aggressiveswallow\ResultQueryInterface;
use Aggressiveswallow\Factories\MenuItemFactory;
use Aggressiveswallow\Models\MenuItem;

/**
 * Get the breadcrum path to a menuitem
 *
 * @author Patrick
 */
class BreadcrumsQuery
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

    public function __construct(\PDO $connection, MenuItemFactory $f) {
        parent::__construct($connection);
        $this->factory = $f;
    }

    public function fetch() {

        if (!isset($this->id)) {
            throw new \Exception("MenuItem not set.");
        }
        $sql = file_get_contents(VENDOR_PATH . "queries/sqlfiles/breadcrums.sql");
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array("id" => $this->id));

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        $crums = array();
        foreach($rows as $row ){
            $crums[] = $this->factory->create($row);
        }
        
        // The last menuItem is the NavigationRoot, remove it
        \array_pop($crums);

        return $crums;
    }

    /**
     * 
     * @param \Aggressiveswallow\Models\MenuItem $mi
     */
    public function setMenuItem(MenuItem $mi) {
        $this->id = $mi->getTree()->getId();
    }

}
