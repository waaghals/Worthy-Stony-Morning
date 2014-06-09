<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace WorthyStonyMorning\Validators;

use Aggressiveswallow\ValidateInterface;

class EventValidator extends AbstractValidator implements ValidateInterface
{

    public function __construct()
    {
        parent::__construct();
        $this->field_names = array(
            "event_title"     => "Titel",
            "event_time"      => "Tijdstip",
            "event_longdesc"  => "Lange omschrijving",
            "event_shortdesc" => "Korte omschrijving",
            "event_email"     => "Email"
        );
    }

    protected function performValidation(array $data)
    {
        if (!\filter_var($data["event_email"], FILTER_VALIDATE_EMAIL)) {
            $this->messages[] = "Er is een ongeldig email adres opgegeven.";
        }
    }

}
