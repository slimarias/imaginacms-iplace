<?php

namespace Modules\Iplaces\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface PlaceRepository extends BaseRepository
{
    /**
     * Return the latest x iblog posts
     * @param int $amount
     * @return Collection
     */
    public function latest($amount = 5);

    /**
     * Get the previous post of the given post
     * @param object $place
     * @return object
     */
    public function getPreviousOf($place);

    /**
     * Get the next post of the given post
     * @param object $place
     * @return object
     */
    public function getNextOf($place);

    /**
     * Get the next post of the given post
     * @param object $id
     * @return object
     */
    public function find($id);



}
