<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace WorthyStonyMorning\Models;

use Aggressiveswallow\Models\BaseEntity;

/**
 * Description of Content
 *
 * @author Waaghals
 */
class Image extends BaseEntity
{

    private $path;

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

}
