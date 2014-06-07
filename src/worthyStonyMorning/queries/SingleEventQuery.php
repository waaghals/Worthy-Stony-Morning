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
class SingleEventQuery extends BaseQuery implements ResultQueryInterface
{

    private $factory;
    private $sqlFile;
    private $eventId;

    public function __construct(\PDO $connection, EventFactory $f)
    {
        parent::__construct($connection);
        $this->factory = $f;
        $this->sqlFile = VENDOR_PATH . "/queries/sqlfiles/singleEvent.sql";
    }

    public function setEventId($eventId)
    {
        $this->eventId = $eventId;
    }

    public function fetch()
    {
        if (is_null($this->eventId)) {
            throw new \Exception("No eventId set for SingleEventQuery");
        }
        $sql  = file_get_contents($this->sqlFile);
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array("id" => $this->eventId));

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $this->factory->create($row);
    }

}
