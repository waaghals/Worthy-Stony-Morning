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
        $t            = new Template("homeViews/frontPage");
        $t->pageTitle = "Home";
        return new Response($t);
    }

}
