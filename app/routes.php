<?php

use Website\Page\Page;

EasyRoute::controller('HomeController', array(

    'home'    => array('/', 'index'),
    'archive' => array('blog-archive/{year}/{month?}', 'archive'),
    'search'  => array('search.html', 'search')

));

EasyRoute::controller('PostsController', array(

    'post' => array('tutorial/{slug}-{id}.html', 'show,addComment')

));

EasyRoute::controller('DownloadsController', array(

    'download' => array('redirect-to-download-{id}.html', 'redirect')

));

EasyRoute::controller('SubscribeController', array(
    'subscribe' => array('subscribe/{step}', 'subscribe@post')
));

EasyRoute::controller('ServicesController', array(

    'services' => array('website-services.html', 'index'),
    'service'  => array('service-{id}.html', 'show')

));

EasyRoute::controller('ContactUsController', array(

    'contact-us' => array('contact-us.html', 'index,send')
));

// Loop through all pages and add route for their slugs...
foreach(Page::all() as $page)
{
    Route::get($page->slug, function() use ($page)
    {
        return View::make('pages.one', compact('page'));
    });
}

EasyRoute::controller('PagesController', array(

    'page' => array('page/{slug}-{id}.html', 'show')
));


Route::get('message-to-user.html', array('as' => 'message-to-user', function()
{
    $messenger = Messenger::get();

    dd($messenger->getTitle());
}));



use Blog\Post\Post;
use Membership\User\User;
use Blog\Page\Page as PostPage;

Route::get('convert',function()
{
    $post = Post::find(17);

    foreach($post->pages as $page)
    {
        $body = html_entity_decode($page->body);

        preg_match_all('/< *img[^>]*src *= *["\']?([^"\']*)/i', $body, $matches);

        for ($i=0; $i < count($matches[0]); $i++)
        {
            $tag    = $matches[0][$i];
            $source = $matches[1][$i];

            if(strpos($source, 'justdevelopwebsites.com/public/albums') > -1)
            {
                $newSource = str_replace('justdevelopwebsites.com/public/albums', 'kareemphp.loc/albums/old_images', $source);

                $page->body = str_replace($source, $newSource, $body);
            }
        }
        $page->save();
    }

//    $posts = Post::all();
//
//    foreach($posts as $post)
//    {
//        foreach($post->pages as $page)
//        {
//            $body = html_entity_decode($page->body);
//
//            preg_match_all('/< *img[^>]*src *= *["\']?([^"\']*)/i', $body, $matches);
//
//            for ($i=0; $i < count($matches[0]); $i++)
//            {
//                $tag    = $matches[0][$i];
//                $source = $matches[1][$i];
//
//                if(strpos($source, 'justdevelopwebsites.com/public/albums') > -1)
//                {
//
//                    $newSource = str_replace('justdevelopwebsites.com/public/albums', 'kareemphp.loc/albums/old_images', $source);
//
//                    $page->body = str_replace($source, $newSource, $body);
//                }
//            }
//            // $page->save();
//        }


        // Creating post
        // $post = new Post(array(
        //     'title' => $oldPost->title,
        //     'description' => $oldPost->_desc,
        //     'tags' => $oldPost->tags,
        //     'slug' => $slug,
        //     'difficulty' => $oldPost->difficulty,
        //     'state' => Post::DRAFT,
        // ));
        // // Attaching post to the boss
        // $user->posts()->save($post);

        // // Creating post pages
        // $oldPages = explode("====PAGE====", $oldPost->body);

        // foreach($oldPages as $oldPage)
        // {
        //     $oldPage = str_replace("====SOURCEFILES====", "", $oldPage);

        //     $oldPage = stripslashes($oldPage);

        //     $post->pages()->create(array(
        //         'body' => $oldPage
        //     ));
        // }
//    }
});