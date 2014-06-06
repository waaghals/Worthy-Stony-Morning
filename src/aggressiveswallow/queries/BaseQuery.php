<?php

namespace Aggressiveswallow\Queries;

use Aggressiveswallow\ResultQueryInterface;

/**
 * Query the latest locations.
 *
 * @author Patrick
 */
abstract class BaseQuery
        implements ResultQueryInterface {

    /**
     *
     * @var array Array with field names in string.
     */
    protected $fields;

    /**
     *
     * @var string Table name where to select from.
     */
    protected $table;

    /**
     *
     * @var string ClassName to Hydrate the data into.
     */
    protected $className;

    /**
     *
     * @var string WHERE, LIMIT, HAVING etc. clauses.
     */
    protected $condition;

    /**
     *
     * @var \PDO
     */
    protected $connection;

    /**
     * 
     * @param \PDO $connection
     */
    public function __construct(\PDO $connection) {
        $this->connection = $connection;
        $this->condition = "";
    }

    protected function fields() {
        if (is_array($this->fields)) {

            // Always include the id field
            if (!in_array("id", $this->fields)) {
                $this->fields[] = "id";
            }
            return "`" . implode("`, `", $this->fields) . "`";
        }
        return "*";
    }

    public function addField($field) {
        if (!is_array($this->fields)) {
            $this->fields = array();
        }

        if (!is_string($field)) {
            throw new Exception("Field is not a valid string.");
        }

        $this->fields[] = $field;
    }

    public function setFields(array $fields) {
        if (!is_array($fields)) {
            addField($fields);
            return;
        }

        foreach ($fields as $field) {
            addField($field);
        }
    }

    public function getCondition() {
        return $this->condition;
    }

    public function setCondition($condition) {
        $this->condition = $condition;
    }

    public function getClassName() {
        return $this->className;
    }

    public function setClassName($className) {
        $reflectionClass = new \ReflectionClass($className);
        $this->table = $reflectionClass->getShortName();
        $this->className = $className;
    }

}
