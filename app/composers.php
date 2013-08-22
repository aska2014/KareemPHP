<?php
use Asset\Asset;
use Website\Page\Page;

// Share error messages along all views
View::share('errors', (array) Session::get('errors', array()));

// Share success messages along all views
View::share('success', (array) Session::get('success', array()));

// Share authenticated user
View::share('authUser', Auth::user());

View::composer(array('layout1.index', 'layout2.index'), function($view)
{
    $view->metaDescription = "In this blog I will be posting web development and design tutorials with PHP, MySQL, Javascript, HTML5 and CSS";
    $view->metaKeywords    = "Develop websites, PHP tutorials, MySQL, JavaScript, JQuery, HTML5, CSS, website tutorials, request a tutorial";
    $view->pageTitle       = isset($view->pageTitle) ? $view->pageTitle: 'Kareem PHP blog for web development tutorials with PHP';

    $view->mainParts = array('scroll_top');
});


View::composer('layout1.index', function($view)
{
    Asset::addPage('layout1');
});

View::composer('layout2.index', function($view)
{
    Asset::addPage('layout2');
});


View::composer('layout1.header', function($view)
{
    $view->menuPages = Page::all();
});


// Layout1 right panel...
// Right panel ...................................
View::composer('layout1.rightpanel', function($view)
{
    $view->rightParts = array('popular', 'archive', 'subscribe');
});

View::composer('rightpanel.archive', function($view)
{
    // Getting Archive from app container to be testable
    $view->archiveYears = App::make('Blog\Archive\Archive')->toYears();
});

View::composer('rightpanel.popular', function($view)
{
   $view->popularPosts = App::make('Blog\Post\PostAlgorithm')->popular()->postState()->take(6)->get();
});
//////////////////////////////////////////////////////////



// Parts ................................................
View::composer('parts.modal', function($view)
{
    Asset::addPlugin('modal');
});

View::composer('parts.php_javascript', function($view)
{
    $view->sqlNow  = date('Y-m-d H:i:s');
    $view->baseUrl = URL::asset('');
});

View::composer('parts.scroll_top', function($view)
{
});
/////////////////////////////////////////////////////////



View::composer('posts.one', function($view)
{
    Asset::addPlugins(array('form', 'syntax'));
});

View::composer('services.one', function($view)
{
    Asset::addPlugin('slider');
});