<?php

namespace WorthyStonyMorning\Controllers;

use Aggressiveswallow\Controllers\BaseController;
use Aggressiveswallow\Helpers\LoginHelper as Login;
use Aggressiveswallow\Tools\Responses\ErrorResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of ImagesController
 *
 * @author Waaghals
 */
class ImageController extends BaseController
{

    public function deleteAction($imageId)
    {
        if (!Login::isLoggedIn()) {
            return new ErrorResponse("Niet toegestaan", Response::HTTP_FORBIDDEN);
        }

        $repo  = Container::make("genericRepository");
        $query = Container::make("singleImageQuery");
        $query->setEventId($imageId);
        $image = $repo->read($query);

        if (is_null($image->getId())) {
            return MessageHelper::error("Afbeelding", "onbekent",
                                        "De afbeelding welke u wilt verwijderen bestaat niet.");
        }

        $repo->delete($imageId);

        return MessageHelper::success("Afbeelding", "verwijderd",
                                      "De afbeeldng is met succes verwijderd.");
    }

    public function createAction()
    {

    }

}
