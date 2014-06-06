<?php
namespace Aggressiveswallow;

/**
 * Interface for storing data, doesn't matter if it is memory, db or file.
 * @author Patrick
 */
interface PersistanceInterface {
    /**
     * 
     * @param mixed $data The data to be persisted
     * @return mixed The key to retrieve the data with
     */
    function persist($data);
    
    /**
     * 
     * @param mixed $key The key to retrieve data with
     * @return mixed The data for the key.
     */
    function retreive($key);
    
    /**
     * 
     * @param mixed $key The key for the data to destroy
     */
    function destroy($key);
}
