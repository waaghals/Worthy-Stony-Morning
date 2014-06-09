<?php

namespace WorthyStonyMorning\Controllers;

use Aggressiveswallow\Controllers\BaseController;
use Aggressiveswallow\Helpers\LoginHelper as Login;
use Aggressiveswallow\Tools\Responses\ErrorResponse;
use Symfony\Component\HttpFoundation\Response;
use Aggressiveswallow\Tools\Container;
use Aggressiveswallow\Tools\Template;
use WorthyStonyMorning\Helpers\MessageHelper;

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
        $query->setImageId($imageId);
        $image = $repo->read($query);

        if (is_null($image->getId())) {
            return MessageHelper::error("Afbeelding", "onbekent",
                                        "De afbeelding welke u wilt verwijderen bestaat niet.");
        }

        $repo->delete($image);

        return MessageHelper::success("Afbeelding", "verwijderd",
                                      "De afbeelding is met succes verwijderd.");
    }

    public function createAction()
    {
        if (!Login::isLoggedIn()) {
            return new ErrorResponse("Niet toegestaan", Response::HTTP_FORBIDDEN);
        }

        if (isset($_POST["submit"])) {

            $validator = Container::make("uploadValidator");
            if (!$validator->isValid($_FILES)) {
                $this->errors = $validator->getMessages();
            } else {
                return $this->handleImageUpload($_FILES["image"]["tmp_name"]);
            }
        }
        return $this->showImageForm($_FILES);
    }

    private function showImageForm($post_data = array())
    {
        $t = new Template("imageViews/uploadForm");
        if (!empty($this->errors)) {
            $t->errors = $this->errors;
        }

        $t->data = $post_data;
        if (is_null($post_data)) {
            $t->data = array();
        }

        $t->pageTitle = "Afbeelding uploaden";

        return new Response($t);
    }

    private function handleImageUpload($tempPath)
    {
        $dest     = BASE_PATH . "public/uploads/%s";
        $filePath = sha1_file($tempPath);
        if (!move_uploaded_file($tempPath, sprintf($dest, $filePath))) {
            return MessageHelper::error("Afbeelding", "foutmelding",
                                        "Kon de afbeelding niet verplaatsen");
        }

        $this->storeImage($filePath);

        return MessageHelper::success("Afbeelding", "opgeslagen",
                                      "De afbeeling is met succes geupload.");
    }

    private function storeImage($path)
    {
        $factory  = Container::make("imageFactory");
        $repo     = Container::make("genericRepository");
        $imageObj = $factory->create(array("image_path" => $path));
        $repo->create($imageObj);
    }

}
