<?php
namespace Aggressiveswallow;

/**
 * Simple interface for data retreival.
 * @author Patrick
 */
interface ResultQueryInterface {
    function fetch();
    function setFields(array $fields);
    function addField($field);
}
