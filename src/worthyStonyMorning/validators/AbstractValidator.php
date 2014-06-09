<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace WorthyStonyMorning\Validators;

use Aggressiveswallow\ValidateInterface;

/**
 * Description of AbstractValidator
 *
 * @author Waaghals
 */
abstract class AbstractValidator implements ValidateInterface
{

    protected $no_key_error;
    protected $to_short_error;
    protected $messages;
    protected $field_names;

    public function __construct()
    {
        $this->no_key_error   = "Sleutel '%s' is niet gevonden in \$_POST data.";
        $this->to_short_error = "Veld '%s' is te kort.";
        $this->messages       = array();
        $this->field_names    = array(); //Overwritten in child constructor
    }

    abstract protected function performValidation(array $post_data);

    public function isValid($data)
    {
        $this->validateManditoryFields($data);
        $this->performValidation($data);

        //Return true when there are no error messages
        return \count($this->messages) == 0;
    }

    public function validateManditoryFields($data)
    {
        foreach ($this->field_names as $key => $v) {
            if (!\array_key_exists($key, $data)) {

                $this->messages[] = \sprintf($this->no_key_error, $key);
            }
            if (\strlen(@$data[$key]) < 3) {
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
