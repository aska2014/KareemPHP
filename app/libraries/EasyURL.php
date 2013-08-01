<?php

use Blog\Post\Post;

class EasyURL extends URL {

    /**
     * @param Post $post
     * @return string
     */
    public static function post( Post $post )
    {
        return static::route('post', array($post->getSlug(), $post->id));
    }

    /**
     * @param $year
     * @param int $month
     * @return string
     */
    public static function blogArchive($year, $month = 0)
    {
        if($month) return static::route('archive', array($year, $month));

        return static::route('archive', array($year));
    }
}