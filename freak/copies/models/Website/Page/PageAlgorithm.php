<?php namespace Website\Page;

use \Illuminate\Database\Query\Builder;

class PageAlgorithm extends \BaseAlgorithm {

	/**
	 * Get an empty query for this model.
	 *
     * @return Builder
	 */
    public function emptyQuery()
    {
        return Page::query();
    }
}