<?php

use Blog\Post\PostAlgorithm;
use Blog\Archive;

class HomeController extends BaseController {

    const POSTS_PER_PAGE = 12;

    /**
     * @param PostAlgorithm $postAlgorithm
     * @param Archive $blogArchive
     */
    public function __construct( PostAlgorithm $postAlgorithm, Archive $blogArchive )
    {
        $this->postAlgorithm = $postAlgorithm;

        $this->blogArchive = $blogArchive;
    }

    /**
     * @return Response
     */
    public function index()
	{
        $posts = $this->postAlgorithm->orderByPostDate('desc')->paginate(self::POSTS_PER_PAGE);

        $homeTitle = 'Recent tutorials';

		return View::make('home.index', compact('posts', 'homeTitle'));
	}

    /**
     * @return Response
     */
    public function search()
    {
        $keyword = Input::get('keyword', '');

        $posts = $this->postAlgorithm->search($keyword)->paginate(self::POSTS_PER_PAGE);

        $homeTitle = 'Searching tutorials with keyword: ' . $keyword;

        return View::make('home.index', compact('posts', 'homeTitle'));
    }

    /**
     * @param $year
     * @param $month
     * @return Response
     */
    public function showByDate( $year, $month )
    {
        $posts = $this->postAlgorithm->year($year)->month($month)->paginate(self::POSTS_PER_PAGE);

        $homeTitle = 'Tutorials in year: ' . $year . ' and month: ' . $month;

        return View::make('home.index', compact('posts', 'homeTitle'));
    }
}