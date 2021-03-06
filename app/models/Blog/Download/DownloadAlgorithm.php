<?php namespace Blog\Download;

use \Illuminate\Database\Query\Builder;

class DownloadAlgorithm extends \BaseAlgorithm {

	/**
	 * Get an empty query for this model.
	 *
     * @return Builder
	 */
    public function emptyQuery()
    {
        return Download::query();
    }
}