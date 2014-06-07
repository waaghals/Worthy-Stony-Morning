<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace WorthyStonyMorning\Validators;

use Aggressiveswallow\ValidateInterface;

class PageValidator implements ValidateInterface
{

    private $no_key_error;
    private $to_short_error;
    private $messages;
    private $field_names;

    public function __construct()
    {
        $this->no_key_error   = "Sleutel '%s' is niet gevonden in \$_POST data.";
        $this->to_short_error = "Veld '%s' is te kort.";
        $this->messages       = array();
        $this->field_names    = array(
            "content_page"    => "Pagina",
            "content_content" => "Inhoud"
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
            "content_page",
            "content_content"
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
    }

    public function getMessages()
    {
        return $this->messages;
    }

}
