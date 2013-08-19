<?php namespace website\Service;

use \Illuminate\Database\Query\Builder;

class ServiceAlgorithm extends \BaseAlgorithm {

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