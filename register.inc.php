<?php

use Aggressiveswallow\Tools\Container;
use Aggressiveswallow\Persistors\DatabasePersistor;
use Aggressiveswallow\Factories\AddressFactory;
use Aggressiveswallow\Factories\LocationFactory;
use Aggressiveswallow\Factories\NavItemFactory;
use Aggressiveswallow\Factories\MenuItemFactory;
use Aggressiveswallow\Queries\FullNavigationQuery;
use Aggressiveswallow\Queries\LatestLocationQuery;
use Aggressiveswallow\Queries\SingleLocationQuery;
use Aggressiveswallow\Repositories\GenericRepository;
use Aggressiveswallow\Queries\BreadcrumsQuery;
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

Container::register("menuItemFactory",
                    function() {
    return new MenuItemFactory();
});

Container::register("navItemFactory",
                    function() {
    $mif = Container::make("menuItemFactory");
    return new NavItemFactory($mif);
});

Container::register("navQuery",
                    function() {
    $db  = Container::make("db");
    $niv = Container::make("navItemFactory");
    return new FullNavigationQuery($db, $niv);
});

Container::register("menuItemDropdownQuery",
                    function() {
    $db  = Container::make("db");
    $miv = Container::make("menuItemFactory");
    return new CategoriesQuery($db, $miv);
});

Container::register("addressFactory",
                    function() {
    return new AddressFactory();
});

Container::register("locationFactory",
                    function() {
    $mif = Container::make("menuItemFactory");
    $af  = Container::make("addressFactory");
    return new LocationFactory($mif, $af);
});

Container::register("latestLocationQuery",
                    function() {
    $db      = Container::make("db");
    $factory = Container::make("locationFactory");
    return new LatestLocationQuery($db, $factory);
});

Container::register("singleLocationQuery",
                    function() {
    $db      = Container::make("db");
    $factory = Container::make("locationFactory");
    return new SingleLocationQuery($db, $factory);
});

Container::register("breadcrumsQuery",
                    function() {
    $db      = Container::make("db");
    $factory = Container::make("menuItemFactory");
    return new BreadcrumsQuery($db, $factory);
});

Container::registerSingleton("navigation",
                             function() {
    $repo = Container::make("GenericRepository");
    $navQ = Container::make("navQuery");

    $navRoot = $repo->read($navQ);
    return $navRoot->getChildren();
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
