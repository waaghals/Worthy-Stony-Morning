<?php

namespace WorthyStonyMorning\Factories;

use Aggressiveswallow\FactoryInterface;
use WorthyStonyMorning\Models\Image;

/**
 * Description of LocationFactory
 *
 * @author Patrick
 */
class ImageFactory implements FactoryInterface
{

    public function create($data)
    {

        $image = new Image();
        if (isset($data["image_id"])) {
            $image->setId(intval($data["image_id"]));
        }
        $image->setPath($data["image_path"]);

        return $image;
    }

}
