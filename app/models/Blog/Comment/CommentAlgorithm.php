<?php namespace Blog\Comment;

use Blog\Post\Post;
use \Illuminate\Database\Query\Builder;

class CommentAlgorithm extends \BaseAlgorithm {

    public function byPost( Post $post )
    {
        $this->getQuery()->where('commentable_id', $post->id)
                         ->where('commentable_type', get_class($post));

        return $this;
    }

    /**
     * @return $this
     */
    public function noParent()
    {
        $this->getQuery()->where('parent_id', null);

        return $this;
    }

    /**
     * @return $this
     */
    public function accepted()
    {
        $this->getQuery()->where('accepted', true);

        return $this;
    }

    /**
     * @return $this
     */
    public function notAccepted()
    {
        $this->getQuery()->where('accepted', false);

        return $this;
    }

	/**
	 * Get an empty query for this model.
	 *
     * @return Builder
	 */
    public function emptyQuery()
    {
        return Comment::query();
    }
}