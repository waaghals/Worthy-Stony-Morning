<?php

use Aggressiveswallow\Tools\Container;
use Aggressiveswallow\Persistors\DatabasePersistor;
use Aggressiveswallow\Factories\AddressFactory;
use Aggressiveswallow\Repositories\GenericRepository;
use Aggressiveswallow\Factories\UserFactory;
use Aggressiveswallow\Queries\UserByNameQuery;
use Aggressiveswallow\Tools\Session;
use Aggressiveswallow\Helpers\Cart;
use Aggressiveswallow\Repositories\OrderRepository;
use Aggressiveswallow\Queries\CategoriesQuery;

// Register the objects
Container::registerSingleton("db",
                             function() {
    return new \PDO("mysql:host=localhost;dbname=wsm", "root", "",
                    array(
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
    ));
});

Container::register("persistor",
                    function() {
    $db = Container::make("db");
    return new DatabasePersistor($db);
});

Container::register("genericRepository",
                    function() {
    $persistor = Container::make("persistor");
    return new GenericRepository($persistor);
});

Container::register("categoryDropdownQuery",
                    function() {
    $db  = Container::make("db");
    $miv = Container::make("categoryFactory");
    return new CategoriesQuery($db, $miv);
});

Container::register("addressFactory",
                    function() {
    return new AddressFactory();
});

Container::registerSingleton("userFactory",
                             function() {
    return new UserFactory();
});

Container::register("userByNameQuery",
                    function() {
    $db      = Container::make("db");
    $factory = Container::make("userFactory");
    return new UserByNameQuery($db, $factory);
});

Container::registerSingleton("session", function() {
    return new Session();
});

Container::registerSingleton("cart", function() {
    return new Cart();
});

Container::register("orderRepository",
                    function() {
    $persistance = Container::make("persistor");
    return new OrderRepository($persistance);
});
