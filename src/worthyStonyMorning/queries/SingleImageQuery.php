<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace WorthyStonyMorning\Queries;

use Aggressiveswallow\Queries\BaseQuery;
use Aggressiveswallow\ResultQueryInterface;
use WorthyStonyMorning\Factories\ImageFactory;

/**
 * Description of AbstractEventQuery
 *
 * @author Waaghals
 */
class SingleImageQuery extends BaseQuery implements ResultQueryInterface
{

    private $factory;
    private $sqlFile;
    private $imageId;

    public function __construct(\PDO $connection, ImageFactory $f)
    {
        parent::__construct($connection);
        $this->factory = $f;
        $this->sqlFile = VENDOR_PATH . "/queries/sqlfiles/singleImage.sql";
    }

    public function setImageId($eventId)
    {
        $this->imageId = $eventId;
    }

    public function fetch()
    {
        if (is_null($this->imageId)) {
            throw new \Exception("No imageId set for SingleImageQuery");
        }
        $sql  = file_get_contents($this->sqlFile);
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array("id" => $this->imageId));

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $this->factory->create($row);
    }

}
