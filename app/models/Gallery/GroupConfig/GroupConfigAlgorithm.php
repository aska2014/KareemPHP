<?php namespace Gallery\GroupConfig;

use \Illuminate\Database\Query\Builder;

class GroupConfigAlgorithm extends \BaseAlgorithm {

	/**
	 * Get an empty query for this model.
	 *
     * @return Builder
	 */
    public function emptyQuery()
    {
        return GroupConfig::query();
    }
}