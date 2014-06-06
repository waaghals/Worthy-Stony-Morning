<?php

namespace Aggressiveswallow\Tools;

/**
 * IoC Container
 *
 * @author Patrick
 */
class Container {

    /**
     * @var array
     */
    protected static $registry = array();

    /**
     * Add a new resolver to the registry array.
     * @param  string $name Key
     * @param  \Closure $resolve Closure that will create the correct instance.
     */
    public static function register($name, \Closure $resolve) {
        $key = strtolower($name);
        static::$registry[$key] = $resolve;
    }

    /**
     * Add a new resolver which will yield the same object every time it is fetched.
     * @param  string $name Key
     * @param  \Closure $resolve Closure that will create the correct instance.
     */
    public static function registerSingleton($name, \Closure $resolve) {
        $key = strtolower($name);
        static::$registry[$key] = $resolve();
    }

    /**
     * Find the closure by $name, then execute it and return te result.
     * @param  string $name The key to which the Closure was registered.
     * @return mixed
     */
    public static function make($name) {
        $item = static::fetch($name);

        if (is_object($item) && ($item instanceof \Closure)) {
            // It is a \Closure
            // Return the executed value.
            return $item();
        } else {
            // It isn't a \Closure anymore
            // Just return the value
            return $item;
        }
    }

    /**
     * 
     * @param string $name
     * @return mixed
     * @throws \Exception When no key by $name existst.
     */
    private static function fetch($name) {
        $key = strtolower($name);
        if (!static::isRegistered($key)) {
            $m = sprintf("No object with name \"%s\" was registered with the container.", $key);
            throw new \Exception($m);
        }

        return static::$registry[$key];
    }

    /**
     * Find if a \Closure is registerd with the key $name.
     * @param  string $name
     * @return boolean True if the key with $name exists
     */
    public static function isRegistered($name) {
        return array_key_exists($name, static::$registry);
    }

}
