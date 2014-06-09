<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace WorthyStonyMorning\Queries;

use Aggressiveswallow\Queries\BaseQuery;
use Aggressiveswallow\ResultQueryInterface;
use WorthyStonyMorning\Factories\EventFactory;

/**
 * Description of AbstractEventQuery
 *
 * @author Waaghals
 */
class EventsQuery extends BaseQuery implements ResultQueryInterface
{

    private $factory;
    private $sqlFile;

    public function __construct(\PDO $connection, EventFactory $f, $type)
    {
        parent::__construct($connection);
        $this->factory = $f;
        $this->sqlFile = sprintf(
                VENDOR_PATH . "/queries/sqlfiles/%sEvents.sql", $type);
    }

    public function fetch()
    {
        $sql  = file_get_contents($this->sqlFile);
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $events = array();
        foreach ($rows as $row) {
            $events[] = $this->factory->create($row);
        }
        return $events;
    }

}
