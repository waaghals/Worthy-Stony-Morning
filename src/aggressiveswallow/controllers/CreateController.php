<?php

namespace Aggressiveswallow\Controllers;

use Aggressiveswallow\Tools\Template;
use Symfony\Component\HttpFoundation\Response;
use Aggressiveswallow\Persistors\DatabasePersistor;
use Aggressiveswallow\Models\Address;
use Aggressiveswallow\Models\Location;
use Aggressiveswallow\Models\Category;
use Aggressiveswallow\Models\Tree;
use Aggressiveswallow\Repositories\GenericRepository;
use Aggressiveswallow\Repositories\TreeRepository;
use Aggressiveswallow\Queries\LatestLocationQuery;
use Aggressiveswallow\Queries\FullTreeQuery;
use Aggressiveswallow\Queries\Treequeries\AddQuery;
use Aggressiveswallow\Queries\Treequeries\SubtractQuery;
use Aggressiveswallow\Models\MenuItem;

/**
 * Description of HomeController
 *
 * @author Patrick
 */
class CreateController
        extends BaseController {

    public function MenuAction() {

        $pdo = new \PDO("mysql:host=localhost;dbname=web2", "root", "", array(
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ));

        $persistor = new DatabasePersistor($pdo);
        $genericRepo = new GenericRepository($persistor);
        $treeRepo = new TreeRepository($persistor);
        $treeRepo->setQueries(new AddQuery($pdo), new SubtractQuery($pdo));


        $root = new Tree();
        $root->setLft(0);
        $root->setRgt(1);
        $treeRepo->create($root);

        $navRoot = new Tree();
        $navRoot->setParent($root);
        $treeRepo->create($navRoot);

        $nav = new MenuItem();
        $nav->setTree($navRoot);
        $nav->setName("Home");
        $nav->setUri("/");
        $genericRepo->create($nav);

        $categoryRoot = new Tree();
        $categoryRoot->setParent($navRoot);
        $treeRepo->create($categoryRoot);

        $cat = new MenuItem();
        $cat->setTree($categoryRoot);
        $cat->setName("Categorien");
        $cat->setUri("/overzicht/producten/categorie=huizen/");
        $genericRepo->create($cat);

        $houseRoot = new Tree();
        $houseRoot->setParent($categoryRoot);
        $treeRepo->create($houseRoot);

        $house = new MenuItem();
        $house->setTree($houseRoot);
        $house->setName("Huizen");
        $house->setUri("/overzicht/producten/categorie=huizen/");
        $genericRepo->create($house);


        /*
          $appartementRoot = new Tree();
          $appartementRoot->setParent($categoryRoot); //$categoryRoot used again! should retrieve it from the db with updated `lft` and `rgt` first.
          $treeRepo->create($appartementRoot);

          $appartement = new MenuItem();
          $appartement->setTree($appartementRoot);
          $appartement->setName("Apartementen");
          $appartement->setUri("/overzicht/bekijken/categorie=apartementen/");
          $genericRepo->create($appartement);

         */

        $roomRoot = new Tree();
        $roomRoot->setParent($houseRoot);
        $treeRepo->create($roomRoot);

        $room = new MenuItem();
        $room->setTree($roomRoot);
        $room->setName("Kamer");
        $room->setUri("/overzicht/bekijken/categorie=kamer/");
        $genericRepo->create($room);

        /*
          $accountRoot = new Tree();
          $accountRoot->setParent($navRoot);
          $treeRepo->create($accountRoot);

          $account = new MenuItem();
          $account->setTree($accountRoot);
          $account->setName("Account");
          $account->setUri("/account/");
          $genericRepo->create($account);

         */
        return new Response("Menu created", Response::HTTP_CREATED);
    }

}
