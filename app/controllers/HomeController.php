<?php

use Blog\Post\PostAlgorithm;
use Blog\Archive\Archive;

class HomeController extends BaseController {

    const POSTS_PER_PAGE = 5;

    /**
     * @param PostAlgorithm $postAlgorithm
     */
    public function __construct( PostAlgorithm $postAlgorithm )
    {
        $this->postAlgorithm = $postAlgorithm;
    }

    /**
     * @return Response
     */
    public function index()
	{
        $posts = $this->postAlgorithm->postState()->orderByPostDate('desc')->paginate(self::POSTS_PER_PAGE);

        $homeTitle = 'Recent tutorials';

        $pageTitle = 'Recent tutorials | Kareem PHP blog for web development tutorials';

		return View::make('home.index', compact('posts', 'homeTitle', 'pageTitle'));
	}

    /**
     * @return Response
     */
    public function search()
    {
        $keyword = Input::get('keyword', '');

        $posts = $this->postAlgorithm->postState()->search($keyword)->paginate(self::POSTS_PER_PAGE);

        $homeTitle = 'Searching tutorials with keyword: ' . $keyword;

        $pageTitle = 'Searching tutorials with keyword: '. $keyword;

        return View::make('home.index', compact('posts', 'homeTitle', 'pageTitle'));
    }

    /**
     * @param $year
     * @param $month
     * @return Response
     */
    public function archive( $year, $month = 0 )
    {
        $posts = $this->postAlgorithm->postState()->year($year);

        $format = 'year: ' . $year;

        if($month)
        {
            $posts = $posts->month($month)->paginate(self::POSTS_PER_PAGE);
            $format .= ' and month: ' . date('F', mktime(0, 0, 0, $month, 1, 0));
        }
        else $posts = $posts->paginate(self::POSTS_PER_PAGE);

        $homeTitle = 'Tutorials in ' . $format;

        $pageTitle = 'Displaying tutorials in ' . $format;

        return View::make('home.index', compact('posts', 'homeTitle', 'pageTitle'));
    }
}