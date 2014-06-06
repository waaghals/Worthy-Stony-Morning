<?php

namespace Aggressiveswallow\Models;

/**
 * A link in the menu
 *
 * @author Patrick
 */
class MenuItem
        extends BaseEntity {

    /**
     *
     * @var string Name of the Menu
     */
    private $name;

    /**
     *
     * @var string Uri where the MenuItem point to
     */
    private $uri;

    /**
     *
     * @var \Aggressiveswallow\Models\Tree
     */
    private $tree;

    /**
     *
     * @var int
     * @virtual
     */
    private $depth;

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    /**
     * 
     * @return \Aggresiveswallow\Models\Tree
     */
    public function getTree() {
        return $this->tree;
    }

    /**
     * 
     * @param \Aggressiveswallow\Models\Tree $tree
     */
    public function setTree(Tree $tree) {
        $this->tree = $tree;
    }

    public function isValid() {
        return strlen($this->name) > 1;
    }

    /**
     * 
     * @return string
     */
    public function getUri() {
        return $this->uri;
    }

    /**
     * 
     * @param string $uri
     */
    public function setUri($uri) {
        if (substr($uri, 0, 1) != "/") {
            throw new \Exception("Not a valid URI was set. Menu uri should always be the full path.");
        }
        $this->uri = $uri;
    }

    /**
     * 
     * @return int
     */
    public function getDepth() {
        return (int) $this->depth;
    }

    /**
     * 
     * @param int $depth
     */
    public function setDepth($depth) {
        $this->depth = $depth;
    }

}
