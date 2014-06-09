<?php

namespace WorthyStonyMorning\Models;

use Aggressiveswallow\Models\BaseEntity;

/**
 * Basic items of a product
 *
 * @author Patrick
 */
class Event extends BaseEntity
{

    private $title;
    private $shortdesc;
    private $longdesc;
    private $time;
    private $email;

    public function getTitle()
    {
        return $this->title;
    }

    public function getShortdesc()
    {
        return $this->shortdesc;
    }

    public function getLongdesc()
    {
        return $this->longdesc;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setShortdesc($shortdesc)
    {
        $this->shortdesc = $shortdesc;
    }

    public function setLongdesc($longdesc)
    {
        $this->longdesc = $longdesc;
    }

    public function setTime($time)
    {
        $this->time = $time;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

}
