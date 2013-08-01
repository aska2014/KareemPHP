<?php

use Blog\Post\Post;

class PostsController extends BaseController {

    /**
     * @var Blog\Post\Post
     */
    protected $post;

    /**
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * @param $slug
     * @param $id
     * @return Response
     */
    public function show($slug, $id)
    {
        $post = $this->post->findOrFail($id);

        return View::make('posts.one', compact('post'));
    }
}