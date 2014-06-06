<?php

namespace Aggressiveswallow\Controllers;

use Aggressiveswallow\Tools\Template;
use Symfony\Component\HttpFoundation\Response;
use Aggressiveswallow\Persistors\DatabasePersistor;
use Aggressiveswallow\Models\Address;
use Aggressiveswallow\Models\Location;
use Aggressiveswallow\Models\Category;
use Aggressiveswallow\Models\Tree;
use Aggressiveswallow\Repositories\GenericRepository;
use Aggressiveswallow\Repositories\TreeRepository;
use Aggressiveswallow\Queries\LatestLocationQuery;
use Aggressiveswallow\Queries\FullTreeQuery;
use Aggressiveswallow\Queries\Treequeries\AddQuery;
use Aggressiveswallow\Queries\Treequeries\SubtractQuery;

/**
 * Description of HomeController
 *
 * @author Patrick
 */
class InfoController
        extends BaseController {

    public function phpAction() {
        ob_start();
        phpinfo();
        $phpinfo = ob_get_contents();
        ob_end_clean();
        return new Response($phpinfo, Response::HTTP_OK);
    }

}
