<?php

namespace Aggressiveswallow\Repositories;

use Aggressiveswallow\PersistanceInterface;
use Aggressiveswallow\Models\BaseEntity;
use Aggressiveswallow\ResultQueryInterface;

/**
 * Repository for locations
 *
 * @author Patrick
 */
class GenericRepository
        extends BaseRepository {

    /**
     *
     * @var Aggressiveswallow\PersistanceInterface; 
     */
    private $persistor;
    private $objReflector;

    public function __construct(PersistanceInterface $persistor) {
        $this->persistor = $persistor;
    }

    /**
     * Create a new object and persist it.
     * @param mixed $object to store
     * @return mixed $object with the Id set.
     * @throws \InvalidArgumentException When the object isn't valid
     * @throws \Exception When an unexpected object is in the entity.
     */
    public function create(BaseEntity $object) {
        $this->objReflector = new \ReflectionObject($object);

        $fields = $this->objReflector->getProperties();
        $bindData = array();

        foreach ($fields as $field) {
            if (!$this->shouldStoreProperty($field)) {
                continue;
            }

            $fieldValue = $this->getPropertyValue($field, $object);
            $fieldName = $field->getName();

            if (is_object($fieldValue)) {
                $fieldReflector = new \ReflectionObject($fieldValue);
                $isBaseEntity = $fieldReflector->isSubclassOf("Aggressiveswallow\Models\BaseEntity");

                if (!$isBaseEntity) {
                    throw new \Exception("Unexpected object in Entity, value isn't subclass of baseEntity'");
                }

                // The returned value from the method is a baseEntity.
                // This means it is a foreignkey to an other field.
                // Persist that entity first, then use that id for the foreignkey.
                self::create($fieldValue);

                // Set the reflector back to the original object
                $this->objReflector = new \ReflectionObject($object);

                $bindData[$fieldName . "_id"] = $fieldValue->getId();
            } elseif (!is_null($fieldValue)) {
                // Do update/store empty fields, let the persistance layer
                // deside what to user.
                // Just a plain type
                $bindData[$fieldName] = $fieldValue;
            }
        }

        $this->persistor->setTableName($this->objReflector->getShortName());
        $idForObject = $this->persistor->persist($bindData);

        $object->setId($idForObject);
        return $object;
    }

    public function delete(BaseEntity $object) {
        if ($object->getId() == null) {
            throw new \Exception("Can't delete \$object because it does not have a Id (PKey)");
        }

        $this->persistor->destroy($object->getId());
    }

    public function read(ResultQueryInterface $query) {
        return $query->fetch();
    }

    public function update(BaseEntity $object) {
        if ($object->getId() == null) {
            throw new \Exception("Can't update \$object because does not have a Id (PKey)");
        }

        // Because create works recursively it has to work with existing id's as well
        // Use a create to update the object.
        return $this->create($object);
    }

    private function shouldStoreProperty(\ReflectionProperty $property) {
        if ($this->isVirtualProperty($property)) {
            return false;
        }

        return $this->hasGetMethod($property);
    }

    private function hasGetMethod(\ReflectionProperty $property) {
        $propName = $property->getName();
        $methodName = sprintf("get%s", ucfirst($propName));

        if (!$this->objReflector->hasMethod($methodName)) {
            return false;
        }

        $method = $this->objReflector->getMethod($methodName);
        return $method->isPublic();
    }

    private function isVirtualProperty($property) {
        $phpDoc = new \phpDocumentor\Reflection\DocBlock($property);

        foreach ($phpDoc->getTags() as $tag) {
            if ($tag->getName() === "virtual") {
                return true;
            }
        }


        return false;
    }

    private function getPropertyValue(\ReflectionProperty $property, BaseEntity $object) {
        if ($this->hasGetMethod($property)) {
            $propName = $property->getName();
            $methodName = sprintf("get%s", ucfirst($propName));

            $method = $this->objReflector->getMethod($methodName);
            return $method->invoke($object);
        }
    }

}
