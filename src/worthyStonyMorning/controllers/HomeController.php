<?php

namespace WorthyStonyMorning\Controllers;

use Aggressiveswallow\Tools\Template;
use Symfony\Component\HttpFoundation\Response;
use Aggressiveswallow\Tools\Container;
use Aggressiveswallow\Controllers\BaseController;

/**
 * Description of HomeController
 *
 * @author Patrick
 */
class HomeController extends BaseController
{

    public function indexAction()
    {
        $t = new Template("homeViews/frontPage");

        $repo         = Container::make("GenericRepository");
        //$latestQ = Container::make("latestLocationQuery");
        //$t->locations = $repo->read($latestQ);
        $t->pageTitle = "Home";
        //$t->cart = $this->session->cart;

        return new Response($t, 200);
    }

}
