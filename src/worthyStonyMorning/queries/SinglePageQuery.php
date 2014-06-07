<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace WorthyStonyMorning\Queries;

use Aggressiveswallow\Queries\BaseQuery;
use Aggressiveswallow\ResultQueryInterface;
use WorthyStonyMorning\Factories\PageFactory;

/**
 * Description of AbstractEventQuery
 *
 * @author Waaghals
 */
class SinglePageQuery extends BaseQuery implements ResultQueryInterface
{

    private $factory;
    private $sqlFile;
    private $pageName;

    public function __construct(\PDO $connection, PageFactory $f)
    {
        parent::__construct($connection);
        $this->factory = $f;
        $this->sqlFile = VENDOR_PATH . "/queries/sqlfiles/singlePage.sql";
    }

    public function setPageName($pageName)
    {
        $this->pageName = $pageName;
    }

    public function fetch()
    {
        if (is_null($this->pageName)) {
            throw new \Exception("No pageName set for SinglePageQuery");
        }
        $sql  = file_get_contents($this->sqlFile);
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array("name" => $this->pageName));

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $this->factory->create($row);
    }

}
