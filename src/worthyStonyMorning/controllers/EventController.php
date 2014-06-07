<?php

namespace WorthyStonyMorning\Controllers;

use Aggressiveswallow\Helpers\LoginHelper as Login;
use Aggressiveswallow\Controllers\BaseController;
use Aggressiveswallow\Tools\Responses\ErrorResponse;
use Symfony\Component\HttpFoundation\Response;
use WorthyStonyMorning\Helpers\MessageHelper;
use Aggressiveswallow\Tools\Template;
use Aggressiveswallow\Tools\Container;

/**
 * Description of HomeController
 *
 * @author Patrick
 */
class EventController extends BaseController
{

    private $errors;

    public function __construct()
    {
        parent::__construct();
    }

    public function listAction()
    {
        $t             = new Template("eventViews/eventList");
        $repo          = Container::make("genericRepository");
        $upcomingQuery = Container::make("upcomingEventsQuery");
        $pastQuery     = Container::make("pastEventsQuery");

        $t->upcoming = $repo->read($upcomingQuery);
        $t->past     = $repo->read($pastQuery);

        return new Response($t);
    }

    public function createAction()
    {
        return $this->handleEventModification($_POST);
    }

    private function createEvent($post_data)
    {
        $eventFactory = Container::make("eventFactory");
        $repo         = Container::make("genericRepository");
        $user         = $eventFactory->create($post_data);
        $repo->create($user);
    }

    private function showEventForm($post_data = array())
    {
        $t = new Template("eventViews/eventForm");
        if (!empty($this->errors)) {
            $t->errors = $this->errors;
        }

        $t->data = $post_data;
        if (is_null($post_data)) {
            $t->data = array();
        }

        return new Response($t);
    }

    public function editAction($eventId)
    {
        if (isset($_POST['submit'])) {
            return $this->handleEventModification($_POST);
        }

        $repo  = Container::make("genericRepository");
        $query = Container::make("singleEventQuery");
        $query->setEventId($eventId);
        $event = $repo->read($query);

        //Transform the object to a array just like $_POST
        $data['event_id']        = $event->getId();
        $data['event_title']     = $event->getTitle();
        $data['event_time']      = strftime('%Y-%m-%dT%H:%M:%S',
                                            strtotime($event->getTime()));
        $data['event_shortdesc'] = $event->getShortdesc();
        $data['event_longdesc']  = $event->getLongdesc();
        $data['event_email']     = $event->getEmail();

        return $this->handleEventModification($data);
    }

    public function deleteAction()
    {

    }

    private function handleEventModification($post_data)
    {
        if (!Login::isLoggedIn()) {
            return new ErrorResponse("Niet toegestaan", Response::HTTP_FORBIDDEN);
        }

        if (isset($post_data["submit"])) {
            $validator = Container::make("eventValidator");
            if (!$validator->isValid($post_data)) {
                $this->errors = $validator->getMessages();
            } else {
                $this->createEvent($post_data);

                return MessageHelper::success("Evenement", "opgeslagen",
                                              "Het evenement is met succes opgeslagen in de database.");
            }
        }
        return $this->showEventForm($post_data);
    }

}
