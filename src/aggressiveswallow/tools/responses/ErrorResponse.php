<?php
namespace Aggressiveswallow\Tools\Responses;

use Symfony\Component\HttpFoundation\Response;
use Aggressiveswallow\Tools\Template;

/**
 * Description of ErrorResponse
 *
 * @author Patrick
 */
class ErrorResponse
        extends Response {

    public function __construct($message, $code = Response::HTTP_OK) {
        $t = new Template("errors/Fatal");
        $t->code = $code;
        $t->type = self::$statusTexts[$code];
        $t->message = $message;
        
        parent::__construct($t, $code);
    }

}
