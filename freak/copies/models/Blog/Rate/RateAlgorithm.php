<?php namespace Blog\Rate;

use \Illuminate\Database\Query\Builder;

class RateAlgorithm extends \BaseAlgorithm {

	/**
	 * Get an empty query for this model.
	 *
     * @return Builder
	 */
    public function emptyQuery()
    {
        return Rate::query();
    }
}