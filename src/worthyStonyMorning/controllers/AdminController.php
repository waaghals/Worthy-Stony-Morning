<?php

namespace WorthyStonyMorning\Controllers;

use Aggressiveswallow\Tools\Template;
use Symfony\Component\HttpFoundation\Response;
use Aggressiveswallow\Tools\Container;
use Aggressiveswallow\Helpers\LoginHelper as Login;
use Aggressiveswallow\Controllers\BaseController;
use WorthyStonyMorning\Helpers\MessageHelper;

/**
 * Description of HomeController
 *
 * @author Patrick
 */
class AdminController extends BaseController
{

    public function __construct()
    {
        if (!Login::isLoggedIn()) {
            return MessageHelper::error("Toegang", "niet toegestaan",
                                        "Deze pagina's is alleen voor administrators");
        }
        parent::__construct();
    }

    public function indexAction()
    {
        $t = new Template("adminViews/adminOverview");

        $repo      = Container::make("genericRepository");
        $query     = Container::make("allEventsQuery");
        $t->events = $repo->read($query);

        return new Response($t);
    }

}
