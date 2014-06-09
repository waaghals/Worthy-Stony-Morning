<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace WorthyStonyMorning\Validators;

use Aggressiveswallow\ValidateInterface;

class PageValidator extends AbstractValidator implements ValidateInterface
{

    public function __construct()
    {
        parent::__construct();
        $this->field_names = array(
            "content_page"    => "Pagina",
            "content_content" => "Inhoud"
        );
    }

    protected function performValidation(array $data)
    {

    }

}
