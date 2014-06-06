<?php

namespace Aggressiveswallow\Tools\Responses;

use Symfony\Component\HttpFoundation\Response;

/**
 * Description of JsonResponse
 *
 * @author Patrick
 */
class JsonResponse
        extends Response {
    
    public function __construct(\JsonSerializable $content, $status = 200, $headers = array()) {
        parent::__construct(json_encode($content), $status, $headers);
    }
}
