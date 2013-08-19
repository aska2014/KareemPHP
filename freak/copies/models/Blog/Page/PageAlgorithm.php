<?php namespace Blog\Page;

use Blog\Post\Post;
use \Illuminate\Database\Query\Builder;

class PageAlgorithm extends \BaseAlgorithm {

    /**
     * @param Post $post
     * @return $this
     */
    public function byPost( Post $post )
    {
        $this->getQuery()->where('post_id', $post->id);

        return $this;
    }

    /**
     * @return $this
     */
    public function order()
    {
        $this->getQuery()->orderBy('order', 'ASC');

        return $this;
    }

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