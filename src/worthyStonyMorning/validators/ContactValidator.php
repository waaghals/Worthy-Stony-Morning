<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace WorthyStonyMorning\Validators;

use Aggressiveswallow\ValidateInterface;

class ContactValidator extends AbstractValidator implements ValidateInterface
{

    public function __construct()
    {
        parent::__construct();
        $this->field_names = array(
            "contact_email"   => "Verzend e-mail",
            "contact_name"    => "Naam",
            "contact_message" => "Bericht"
        );
    }

    protected function performValidation(array $post_data)
    {
        if (!\filter_var($post_data["contact_email"], FILTER_VALIDATE_EMAIL)) {
            $this->messages[] = "Er is een ongeldig email adres opgegeven.";
        }
    }

}
