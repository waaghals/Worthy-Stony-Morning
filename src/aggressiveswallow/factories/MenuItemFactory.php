<?php

namespace Aggressiveswallow\Factories;

use Aggressiveswallow\FactoryInterface;
use Aggressiveswallow\Models\MenuItem;
use Aggressiveswallow\Models\Tree;

/**
 * Description of NavItemFactory
 *
 * @author Patrick
 */
class MenuItemFactory
        implements FactoryInterface {

    public function create($data) {

        $menuItem = new MenuItem();
        $menuItem->setId(intval($data["menuitem_id"]));
        $menuItem->setName($data["menuitem_name"]);
        $menuItem->setUri($data["menuitem_uri"]);
        
        if(isset($data["depth"])){
            $menuItem->setDepth($data["depth"]);
        }

        if (isset($data['tree_id'])) {
            $tree = new Tree();
            $tree->setId(intval($data["tree_id"]));
            $tree->setLft($data["tree_lft"]);
            $tree->setRgt($data["tree_rgt"]);
            $menuItem->setTree($tree);
        }

        return $menuItem;
    }

}
