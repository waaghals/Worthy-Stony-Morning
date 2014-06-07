<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace WorthyStonyMorning\Validators;

use Aggressiveswallow\ValidateInterface;

class EventValidator implements ValidateInterface
{

    private $no_key_error;
    private $to_short_error;
    private $invalid_email;
    private $messages;
    private $field_names;

    public function __construct()
    {
        $this->no_key_error   = "Sleutel '%s' is niet gevonden in \$_POST data.";
        $this->to_short_error = "Veld '%s' is te kort.";
        $this->invalid_email  = "Er is een ongeldig email adres opgegeven.";
        $this->messages       = array();
        $this->field_names    = array(
            "event_title"     => "Titel",
            "event_time"      => "Tijdstip",
            "event_longdesc"  => "Lange omschrijving",
            "event_shortdesc" => "Korte omschrijving",
            "event_email"     => "Email"
        );
    }

    public function isValid($data)
    {
        $this->setMessages($data);
        return \count($this->messages) == 0;
    }

    private function setMessages($data)
    {
        $neededKeys = array(
            "event_title",
            "event_time",
            "event_longdesc",
            "event_shortdesc",
            "event_email"
        );

        foreach ($neededKeys as $key) {
            if (!\array_key_exists($key, $data)) {

                $this->messages[] = \sprintf($this->no_key_error, $key);
            }
        }

        foreach ($neededKeys as $key) {
            if (\strlen($data[$key]) < 3) {
                $fieldName        = $this->field_names[$key];
                $this->messages[] = \sprintf($this->to_short_error, $fieldName);
            }
        }

        if (!\filter_var($data["event_email"], FILTER_VALIDATE_EMAIL)) {
            $this->messages[] = $this->invalid_email;
        }
    }

    public function getMessages()
    {
        return $this->messages;
    }

}
