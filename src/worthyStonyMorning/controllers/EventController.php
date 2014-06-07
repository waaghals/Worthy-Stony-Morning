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
        Container::make("genericRepository");
    }

    public function createAction()
    {
        if (!Login::isLoggedIn()) {
            return new ErrorResponse("Niet toegestaan", Response::HTTP_FORBIDDEN);
        }


        if (isset($_POST["submit"])) {
            $validator = Container::make("eventValidator");
            if (!$validator->isValid($_POST)) {
                $this->errors = $validator->getMessages();
            } else {
                $this->createEvent($_POST);

                return MessageHelper::success("Evenement", "aangemaakt",
                                              "Het evenement is met succes aangemaakt in de database.");
            }
        }
        return $this->showEventForm($_POST);
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

    public function editAction()
    {

    }

    public function deleteAction()
    {

    }

}
