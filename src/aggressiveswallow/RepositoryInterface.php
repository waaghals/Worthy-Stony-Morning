<?php
namespace Aggressiveswallow;

use Aggressiveswallow\Models\BaseEntity;

/**
 * Interface for CRUD actions
 * @author Patrick
 */
interface RepositoryInterface {
    function create(BaseEntity $object);
    function read(ResultQueryInterface $query);
    function update(BaseEntity $object);
    function delete(BaseEntity $object);
}
