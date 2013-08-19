<?php namespace Website\Subscribe;

use \Illuminate\Database\Query\Builder;

class SubscribeAlgorithm extends \BaseAlgorithm {

	/**
	 * Get an empty query for this model.
	 *
     * @return Builder
	 */
    public function emptyQuery()
    {
        return Subscriber::query();
    }
}