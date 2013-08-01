<?php
use Asset\Asset;

// Share error messages along all views
View::share('errors', (array) Session::get('errors', array()));

// Share success messages along all views
View::share('success', (array) Session::get('success', array()));



View::composer('layout1.index', function($view)
{
    $view->metaDescription = "JustDevelopWebsites helps web developers build exceptional functionalities in their websites, it's updated every 4 days with a unique tutorial on PHP, MySQL, JavaScript, JQuery, XHTML and CSS, you can also request a tutorial";
    $view->metaKeywords    = "Develop websites, PHP tutorials, MySQL, JavaScript, JQuery, XHTML, CSS, website tutorials, request a tutorial";
    $view->pageTitle       = isset($view->pageTitle) ? $view->pageTitle: 'Kareem PHP personal blog for php tutorials';
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
    $view->archive = App::make('Blog\Archive')->toArray();
});

View::composer('rightpanel.popular', function($view)
{
   $view->popular = App::make('Blog\Post\PostAlgorithm')->popular()->get();
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




