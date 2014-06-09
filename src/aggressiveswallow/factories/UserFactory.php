<?php

namespace Aggressiveswallow\Factories;

use Aggressiveswallow\FactoryInterface;
use Aggressiveswallow\Models\User;

/**
 * Description of UserFactory
 *
 * @author Patrick
 */
class UserFactory
        implements FactoryInterface {

    public function create($data) {
        $user = new User();
        $user->setId((int) $data["user_id"]);
        $user->setName($data["user_name"]);
        $user->setPasshash($data["user_passhash"]);
        $user->setSalt($data["user_salt"]);

        return $user;
    }

    public function createFromUserAndPass($username, $password) {
        $user = new User();
        $user->setName($username);
        \mt_srand(\microtime() + $username + $password);
        $salt = \mt_rand(0, \mt_getrandmax());
        $user->setSalt($salt);
        $user->setPassword($password);

        return $user;
    }

}
