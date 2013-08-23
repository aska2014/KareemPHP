<?php

use Blog\Post\PostAlgorithm;

class SiteMapController extends BaseController {

    /**
     * @var Blog\Post\PostAlgorithm
     */
    protected $postsAlgorithm;

    /**
     * @param PostAlgorithm $postsAlgorithm
     */
    public function __construct(PostAlgorithm $postsAlgorithm)
    {
        $this->postsAlgorithm = $postsAlgorithm;
    }

    /**
     * Printing xml sitemap
     */
    public function xml()
    {
        header("Content-type: text/xml");

        echo'<?xml version=\'1.0\' encoding=\'UTF-8\'?>';
        echo'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

        echo '<url>';
        echo '<loc>'. URL::route('home') .'</loc>';
        echo '<changefreq>always</changefreq>';
        echo '</url>';
        echo '<url>';
        echo '<loc>'. URL::route('services') .'</loc>';
        echo '<changefreq>weekly</changefreq>';
        echo '</url>';
        echo '<url>';
        echo '<loc>'. URL::to('about-me.html') .'</loc>';
        echo '<changefreq>monthly</changefreq>';
        echo '</url>';


        $posts = $this->postsAlgorithm->get();

        foreach ($posts as $post) {
            echo '<url>';
            echo '<loc>'.EasyURL::post($post).'</loc>';
            echo '<changefreq>always</changefreq>';
            echo '</url>';
        }

        echo '</urlset>';
    }

}