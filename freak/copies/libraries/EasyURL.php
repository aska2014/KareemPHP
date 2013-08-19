<?php

use Blog\Demo\Demo;
use Blog\Download\Download;
use Blog\Post\Post;
use website\Service\Service;

class EasyURL extends URL {

    /**
     * @param Service $service
     * @return string
     */
    public static function service( Service $service )
    {
        return static::route('service', $service->id);
    }

    /**
     * @param Download $download
     * @return string
     */
    public static function download( Download $download )
    {
        return static::route('download', $download->id);
    }

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