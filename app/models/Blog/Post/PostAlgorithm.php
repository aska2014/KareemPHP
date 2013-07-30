<?php namespace Blog\Page;

use \Illuminate\Database\Query\Builder;

class PostAlgorithm extends \BaseAlgorithm {

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