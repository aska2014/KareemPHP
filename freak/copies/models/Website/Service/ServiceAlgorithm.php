<?php namespace website\Service;

use \Illuminate\Database\Query\Builder;

class ServiceAlgorithm extends \BaseAlgorithm {

    /**
     * @return $this
     */
    public function order()
    {
        $this->getQuery()->orderBy('created_at', 'DESC');

        return $this;
    }

	/**
	 * Get an empty query for this model.
	 *
     * @return Builder
	 */
    public function emptyQuery()
    {
        return Service::query();
    }
}