<?php

namespace Aggressiveswallow\Helpers;

use Aggressiveswallow\Tools\Container;

/**
 * Description of LoginHelper
 *
 * @author Patrick
 */
class LoginHelper {

    /**
     * 
     * @return boolean True is a user is currently logged in.
     */
    public static function isLoggedIn() {
        $sess = Container::make("session");
        /* @var $sess \Aggressiveswallow\Tools\Session */
        if ($sess->has("isLoggedIn")) {
            return $sess->isLoggedIn;
        }
        return false;
    }

    public static function getLoggedInUser() {
        if (static::isLoggedIn()) {
            $sess = Container::make("session");
            /* @var $sess \Aggressiveswallow\Tools\Session */
            
            return $sess->user;
        }

        return null;
    }

    /**
     * Check if a user exists for the supplied username and password.
     * 
     * @param string $username
     * @param string $password
     * @return boolean
     */
    public static function isValidLogin($username, $password) {
        $user = static::getUserByName($username);
        if (is_null($user)) {
            return false;
        }

        return $user->hasPassword($password);
    }

    /**
     * Get a user object from a name.
     * 
     * @param type $username
     * @return \Aggressiveswallow\Models\User or null if there isn't a user with $username.
     */
    public static function getUserByName($username) {
        $repo = Container::make("genericRepository");
        $q = Container::make("userByNameQuery");
        $q->setName($username);

        /* @var $user \Aggressiveswallow\Models\User */
        $user = $repo->read($q);

        if ($user->getName() == null) {
            return null;
        }
        return $user;
    }

}
