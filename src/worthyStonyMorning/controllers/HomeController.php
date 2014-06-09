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

        $repo  = Container::make("genericRepository");
        $query = Container::make("singlePageQuery");
        $query->setPageName("home");

        $page       = $repo->read($query);
        $t->content = $page->getContent();

        $imgQuery  = Container::make("allImagesQuery");
        $t->images = $repo->read($imgQuery);
        return new Response($t);
    }

}
