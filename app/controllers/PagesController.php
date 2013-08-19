<?php

use Website\Page\Page;

class PagesController extends BaseController {

    /**
     * @var Website\Page\Page
     */
    protected $pages;

    /**
     * @param Page $pages
     */
    public function __construct(Page $pages)
    {
        $this->pages = $pages;
    }

    /**
     * @param $slug
     * @param $id
     * @return mixed
     */
    public function show( $slug, $id )
    {
        $page = $this->pages->findOrFail($id);

        // To remove page duplication
        if(! $page->sameSlug($slug)) return Redirect::to(EasyURL::page($page));

        return View::make('pages.one', compact('page'));
    }

}