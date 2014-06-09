<?php

namespace WorthyStonyMorning\Controllers;

use Aggressiveswallow\Controllers\BaseController;
use WorthyStonyMorning\Helpers\MessageHelper;
use Aggressiveswallow\Tools\Container;
use Aggressiveswallow\Helpers\LoginHelper as Login;
use Aggressiveswallow\Tools\Template;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of HomeController
 *
 * @author Patrick
 */
class PageController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function editAction($pageName)
    {
        $validPages = array('home', 'contact');
        if (!\in_array($pageName, $validPages)) {
            return MessageHelper::error("Pagina", "onbekend",
                                        "De pagina welke u wilt bewerken is onbekend.");
        }

        if (isset($_POST['submit'])) {
            return $this->handlePageModification($_POST);
        }

        $repo    = Container::make("genericRepository");
        $query   = Container::make("singlePageQuery");
        $query->setPageName($pageName);
        $content = $repo->read($query);

        if (is_null($content->getId())) {
            return MessageHelper::error("Pagina", "onbekend",
                                        "De pagina kon niet worden gevonden in de database.");
        }

        //Transform the object to a array just like $_POST
        $data['content_id']      = $content->getId();
        $data['content_page']    = $content->getPage();
        $data['content_content'] = $content->getContent();

        return $this->handlePageModification($data);
    }

    private function handlePageModification($post_data)
    {
        if (!Login::isLoggedIn()) {
            return new ErrorResponse("Niet toegestaan", Response::HTTP_FORBIDDEN);
        }

        if (isset($post_data["submit"])) {
            $validator = Container::make("pageValidator");
            if (!$validator->isValid($post_data)) {
                $this->errors = $validator->getMessages();
            } else {
                $this->storePage($post_data);

                return MessageHelper::success("Pagina", "opgeslagen",
                                              "De pagina is met succes opgeslagen in de database.");
            }
        }
        return $this->showPageForm($post_data);
    }

    private function showPageForm($post_data = array())
    {
        $t = new Template("pageViews/pageForm");
        if (!empty($this->errors)) {
            $t->errors = $this->errors;
        }

        $t->data = $post_data;
        if (is_null($post_data)) {
            $t->data = array();
        }

        $t->pageTitle = "Pagina bewerken";

        return new Response($t);
    }

    private function storePage($post_data)
    {
        $eventFactory = Container::make("pageFactory");
        $repo         = Container::make("genericRepository");
        $page         = $eventFactory->create($post_data);
        $repo->create($page);
    }

}
