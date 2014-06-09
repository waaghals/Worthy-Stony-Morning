<?php

namespace Aggressiveswallow\Tools;

/**
 * Simple session wrapper, uses a fluent interface.
 *
 * @author Patrick
 */
class Session {

    /**
     * Start the session
     * 
     * @return \Aggressiveswallow\Tools\Session
     */
    public function __construct() {
        return $this->start();
    }

    /**
     * Start the session
     * 
     * @return \Aggressiveswallow\Tools\Session
     */
    public function start() {
        \session_start();
        return $this;
    }

    /**
     * Update the sessionId, should be updated after login
     * 
     * @return \Aggressiveswallow\Tools\Session
     */
    public function regenerateId() {
        $this->checkStarted();
        
        \session_regenerate_id(true);
        return $this;
    }

    /**
     * Remove a object with key $name
     * 
     * @param string $name
     * @return \Aggressiveswallow\Tools\Session
     */
    public function remove($name) {
        $this->checkStarted();
        
        if ($this->has($name)) {
            unset($_SESSION[$name]);
        }

        return $this;
    }

    /**
     * Check if the current session has a item with that name
     * 
     * @param type $name
     * @return boolean true if the key by $name exists.
     */
    public function has($name) {
        $this->checkStarted();
        
        return isset($_SESSION[$name]);
    }

    /**
     * Destroy the session
     * 
     * @return \Aggressiveswallow\Tools\Session
     */
    public function destroy() {
        $this->checkStarted();
        
        $_SESSION = array();
        \session_destroy();
        return $this;
    }

    /**
     * Store data $value with key $name in the session.
     * 
     * @param string $name
     * @param mixed $value
     * @return \Aggressiveswallow\Tools\Session
     */
    public function __set($name, $value) {
        $this->checkStarted();
        
        $_SESSION[$name] = $value;
        return $this;
    }

    /**
     * Retrieve data from the session by $name
     * 
     * @param type $name
     * @return mixed Data if key exists, null otherwise.
     */
    public function __get($name) {
        $this->checkStarted();
        
        if ($this->has($name)) {
            return $_SESSION[$name];
        }

        return null;
    }
    
    /**
     * Check if the session is started.
     * 
     * @return boolean True if the session is started/active
     */
    public function isStarted() {
       return \session_status() == \PHP_SESSION_ACTIVE;
    }
    
    /**
     * Check if a session exists, throw an exception if it isn't
     * 
     * @throws \Exception Thrown if no session is started.
     */
    public function checkStarted(){
        if(!$this->isStarted()){
            throw new \Exception("Session is not started.");
        }
    }

}
