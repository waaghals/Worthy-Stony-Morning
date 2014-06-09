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

        $repo       = Container::make("genericRepository");
        $eventQuery = Container::make("allEventsQuery");
        $t->events  = $repo->read($eventQuery);

        $imgQuery  = Container::make("allImagesQuery");
        $t->images = $repo->read($imgQuery);

        return new Response($t);
    }

}
