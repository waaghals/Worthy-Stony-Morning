<?php

namespace WorthyStonyMorning\Factories;

use Aggressiveswallow\FactoryInterface;
use WorthyStonyMorning\Models\Event;

/**
 * Description of LocationFactory
 *
 * @author Patrick
 */
class EventFactory implements FactoryInterface
{

    public function create($data)
    {

        $event = new Event();
        if (isset($data["event_id"])) {
            $event->setId(intval($data["event_id"]));
        }
        $event->setTitle($data["event_title"]);
        $event->setTime($data["event_time"]);
        $event->setLongdesc($data["event_longdesc"]);
        $event->setShortdesc($data["event_shortdesc"]);
        $event->setEmail($data["event_email"]);

        return $event;
    }

}
