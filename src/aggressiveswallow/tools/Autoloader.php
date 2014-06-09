<?php

namespace Aggressiveswallow\Tools;

/**
 * Automatticly load classes from their namespace using the PSR-0 standard.
 *
 * @author Patrick
 */
class Autoloader {

    private $sourceLocation;

    public function __construct($sourceLocation = null) {
        if (!is_null($sourceLocation)) {
            $this->setSourceLocation($sourceLocation);
        }
    }

    /**
     * Register this autoloader with the php system.
     */
    public function register() {
        spl_autoload_register(array($this, 'autoLoad'));
    }

    /**
     * Try to load the php classes with require using the PSR-0 standard.
     * @param string $className The className to load
     */
    private function autoLoad($className) {
        require $this->getPathForClass($className);
    }

    /**
     * Get the path for the class which is being loaded.
     * @param string $className The className to load
     * @return string Path to class
     */
    public function getPathForClass($className) {
        $className = ltrim($className, '\\');
        $fileName = '';
        $namespace = '';
        if ($lastNsPos = strripos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName = str_replace('\\', DS, $namespace) . DS;
        }
        $fileName .= str_replace('_', DS, $className) . '.php';
        return $this->sourceLocation . $fileName;
    }

    /**
     * Set the source location folder to start the search in for the php classes.
     * @param string $sourceLocation
     * @throws Exception When $sourceLocation isn't a string or a valid directory.
     */
    public function setSourceLocation($sourceLocation) {
        if (!is_string($sourceLocation)) {
            $msg = "sourceLocation in Autoloader::__construct should be of type string.";
            throw new Exception($msg);
        }

        if (!is_dir($sourceLocation)) {
            $msg = "sourceLocation in Autoloader::__construct is not a folder.";
            throw new Exception($msg);
        }

        $this->sourceLocation = $sourceLocation . DS;
    }
    
    public function classExists($className) {
        return file_exists($this->getPathForClass($className));
    }

}
