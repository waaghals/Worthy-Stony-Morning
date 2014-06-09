<?php

namespace Aggressiveswallow\Factories;

use Aggressiveswallow\FactoryInterface;
use Aggressiveswallow\Helpers\NavItem;

/**
 * Description of NavItemFactory
 *
 * @author Patrick
 */
class NavItemFactory
        implements FactoryInterface {

    /**
     *
     * @var \Aggressiveswallow\Factories\MenuItemFactory 
     */
    private $menuItemFactory;

    public function __construct(MenuItemFactory $factroy) {
        $this->menuItemFactory = $factroy;
    }

    /**
     * Returns a complete NavItem tree with childs added.
     * 
     * @param array $data Assoc array retured from the database.
     * @return \Aggressiveswallow\Helpers\NavItem
     */
    public function create($data) {
        $nested = $this->nestify($data);
        
        return $this->createNavItem($nested[0]);
    }

    /**
     * Apply pure magic to the resultset.
     * 
     * @param mixed $data Resultset array
     * @return mixed Nested resultset array
     * @see http://stackoverflow.com/a/886931
     * @author wimvds 
     */
    private function nestify($collection) {
        // Trees mapped
        $trees = array();
        $l = 0;

        if (count($collection) > 0) {
            // Node Stack. Used to help building the hierarchy
            $stack = array();

            foreach ($collection as $node) {
                $item = $node;
                $item['children'] = array();

                // Number of stack items
                $l = count($stack);

                // Check if we're dealing with different levels
                while ($l > 0 && $stack[$l - 1]['depth'] >= $item['depth']) {
                    array_pop($stack);
                    $l--;
                }

                // Stack is empty (we are inspecting the root)
                if ($l == 0) {
                    // Assigning the root node
                    $i = count($trees);
                    $trees[$i] = $item;
                    $stack[] = & $trees[$i];
                } else {
                    // Add node to parent
                    $i = count($stack[$l - 1]['children']);
                    $stack[$l - 1]['children'][$i] = $item;
                    $stack[] = & $stack[$l - 1]['children'][$i];
                }
            }
        }

        return $trees;
    }
    
    /**
     * Build a NavItem recursivly
     * @param array $array Nested assoc array.
     * @return \Aggressiveswallow\Helpers\NavItem
     */
    private function createNavItem($array) {
        $menuItem = $this->menuItemFactory->create($array);

        $navItem = new NavItem();
        $navItem->setMenuItem($menuItem);

        if (count($array["children"]) > 0) {
            foreach ($array["children"] as $child) {

                $childNavItem = $this->createNavItem($child);
                $navItem->addChild($childNavItem);
            }
        }
        return $navItem;
    }

}
