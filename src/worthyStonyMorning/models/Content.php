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
class Content extends BaseEntity
{

    private $page;
    private $content;

    public function getPage()
    {
        return $this->page;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setPage($page)
    {
        $this->page = $page;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

}
