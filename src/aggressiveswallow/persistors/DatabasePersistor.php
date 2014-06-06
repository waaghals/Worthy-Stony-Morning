<?php

namespace Aggressiveswallow\Persistors;

use Aggressiveswallow\PersistanceInterface;

/**
 * Persist object in the database.
 *
 * @author Patrick
 */
class DatabasePersistor
        implements PersistanceInterface {

    /**
     *
     * @var \PDO The database connection.
     */
    protected $connection;

    /**
     *
     * @var string Name of the database table the data will be stored in.
     */
    private $tableName;

    /**
     *
     * @var array Key value map with the property names as keys.
     */
    private $entityData;

    /**
     * 
     * @param \PDO $connection The \PDO connection on which the queries are ran.
     */
    public function __construct(\PDO $connection) {
        $this->connection = $connection;
    }

    public function persist($data) {
        $this->entityData = $data;

        // Does it exists in the database?
        // In others words, does it have an id.
        if (isset($this->entityData["id"]) && $this->entityData["id"] != null) {

            // Id exist, so update the entity
            $this->update($this->entityData);
            return $this->entityData["id"];
        }

        // No id is set, store a new entity
        $this->insert($this->entityData);
        return (int) $this->connection->lastInsertId();
    }

    public function retreive($key) {
        return $this->select($key);
    }

    /**
     * Get the properties and their values from an object using reflection
     * 
     * @param mixed $object the object to get the properties from
     * @return array Key value map with the property names as keys.
     */
    private function getPropertiesFromObject($object) {
        $reflector = new \ReflectionObject($object);
        $fields = $reflector->getProperties();
        $bindData = array();

        foreach ($fields as $field) {
            $fieldName = $field->getName();
            $methodName = sprintf("get%s", ucfirst($fieldName));
            $fieldValue = $reflector->getMethod($methodName)->invoke($object);

            $bindData[$fieldName] = $fieldValue;
        }
        return $bindData;
    }

    /**
     * Insert the entityData in the database
     */
    private function insert() {

        // Don't need the id now, remove it from the entityData
        $data = $this->entityData;
        unset($data['id']);

        $fields = array_keys($data);

        // build query...
        $sql = sprintf("INSERT INTO `%s` ", $this->tableName);

        // implode keys of $array...
        $sql .= "(`" . implode("`, `", $fields) . "`)";

        // implode values of $array...
        $sql .= " VALUES (:" . implode(", :", $fields) . ");";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($data);
    }

    /**
     * Update the entityData in the database.
     */
    private function update() {

        $sql = sprintf("UPDATE `%s` SET ", $this->tableName);
        $setters = array();
        foreach ($this->entityData as $field => $value) {
            if ($field === "id") {
                //Skip the id field, this is used in the where clause.
                continue;
            }
            $setters[] = sprintf("`%s` = :%s", $field, $field);
        }
        $sql .= implode(", ", $setters);
        $sql .= " WHERE `id` = :id";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($this->entityData);
    }

    private function select($key) {
        die("TODO");
    }

    /**
     * 
     * @param mixed $object The object to get the table name for.
     */
    private function getTableNameFromObject($object) {
        $reflector = new \ReflectionObject($object);

        return $reflector->getShortName();
    }

    public function getTableName() {
        return $this->tableName;
    }

    public function setTableName($tableName) {
        $this->tableName = $tableName;
    }

    /**
     * 
     * @return \PDO
     */
    public function getConnection() {
        return $this->connection;
    }

    /**
     * 
     * @param \PDO $connection
     */
    public function setConnection(\PDO $connection) {
        $this->connection = $connection;
    }

    public function destroy($key) {
        if(!is_int($key)){
            throw new \Exception("Could not destroy data with \$key because \$key isn't an int.");
        }
        
        $sql = sprintf("DELETE FROM `%s` WHERE `id` = :id", $this->tableName);
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(":id", $key);
        $stmt->execute();
    }

}
