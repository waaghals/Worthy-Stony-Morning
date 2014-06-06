<?php
namespace Aggressiveswallow\Repositories;

use Aggressiveswallow\RepositoryInterface;
use Aggressiveswallow\PersistanceInterface;

/**
 * Basic implementation of a repository with a persistant storage.
 *
 * @author Patrick
 */
abstract class BaseRepository
        implements RepositoryInterface {

    /**
     *
     * @var Aggressiveswallow\PersistanceInterface
     */
    protected $persistance;

    public function __construct(PersistanceInterface $persistance) {
        $this->persistance = $persistance;
    }

}
