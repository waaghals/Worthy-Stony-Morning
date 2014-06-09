<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace WorthyStonyMorning\Validators;

use Aggressiveswallow\ValidateInterface;

class UploadValidator extends AbstractValidator implements ValidateInterface
{

    const FIELD_NAME = "image";

    public function __construct()
    {
        $this->messages    = array();
        $this->field_names = array(
            self::FIELD_NAME => "Bestand"
        );
    }

    public function isValid($data)
    {
        $this->performValidation($data);

        //Return true when there are no error messages
        return \count($this->messages) == 0;
    }

    protected function performValidation(array $data)
    {
        // Check for any upload errors
        switch ($data[self::FIELD_NAME]['error']) {
            case UPLOAD_ERR_OK:
                //Do nothing
                break;
            case UPLOAD_ERR_NO_FILE:
                $this->messages[] = "Geen bestand geupload";
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $this->messages[] = "Upload limit overschreden";
            default:
                $this->messages[] = "Onbekende error";
        }

        $this->checkMime($data[self::FIELD_NAME]['tmp_name']);
    }

    private function checkMime($tempName)
    {
        //Check for valid mime type
        switch (exif_imagetype($tempName)) {
            case IMAGETYPE_GIF:
            case IMAGETYPE_JPEG:
            case IMAGETYPE_PNG:
            case IMAGETYPE_BMP:
                //Do nothing
                break;
            default:
                $this->messages[] = "Niet toegestaand bestands type";
        }
    }

}
