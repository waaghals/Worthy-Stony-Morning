<?php

namespace WorthyStonyMorning\Factories;

use Aggressiveswallow\FactoryInterface;
use WorthyStonyMorning\Models\Content;

/**
 * Description of LocationFactory
 *
 * @author Patrick
 */
class PageFactory implements FactoryInterface
{

    public function create($data)
    {
        $page = new Content();
        if (isset($data["content_id"])) {
            $page->setId(intval($data["content_id"]));
        }
        $page->setPage($data["content_page"]);
        $page->setContent($data["content_content"]);

        return $page;
    }

}
