<?php namespace Blog\Demo;

use \Illuminate\Database\Query\Builder;

class DemoAlgorithm extends \BaseAlgorithm {

	/**
	 * Get an empty query for this model.
	 *
     * @return Builder
	 */
    public function emptyQuery()
    {
        return Demo::query();
    }
}