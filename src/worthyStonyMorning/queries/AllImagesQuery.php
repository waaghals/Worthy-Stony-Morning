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
class AllImagesQuery extends BaseQuery implements ResultQueryInterface
{

    private $factory;
    private $sqlFile;

    public function __construct(\PDO $connection, ImageFactory $f)
    {
        parent::__construct($connection);
        $this->factory = $f;
        $this->sqlFile = sprintf(
                VENDOR_PATH . "/queries/sqlfiles/allImages.sql");
    }

    public function fetch()
    {
        $sql  = file_get_contents($this->sqlFile);
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $images = array();
        foreach ($rows as $row) {
            $images[] = $this->factory->create($row);
        }
        return $images;
    }

}
