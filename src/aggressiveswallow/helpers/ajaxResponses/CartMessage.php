<?php

namespace Aggressiveswallow\Helpers\AjaxResponses;

class CartMessage
        implements \JsonSerializable {

    private $message;
    private $hasError;

    function __construct($message = "", $hasError = false) {
        $this->message = $message;
        $this->hasError = $hasError;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function setHasError($hasError) {
        $this->hasError = $hasError;
    }

    public function jsonSerialize() {
       return [
            'message' => $this->message,
            'hasError' => $this->hasError
        ];
    }

}
