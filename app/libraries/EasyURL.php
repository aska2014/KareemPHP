<?php

use Blog\Post\Post;

class EasyURL extends URL {

    /**
     * @param Post $post
     * @return string
     */
    public function post( Post $post )
    {
        return static::route('post', array($post->getSlug(), $post->id));
    }
}