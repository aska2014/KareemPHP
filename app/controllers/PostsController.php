<?php

use Blog\Comment\Comment;
use Blog\Comment\CommentAlgorithm;
use Blog\Page\PageAlgorithm;
use Blog\Post\Post;
use Blog\Post\PostAlgorithm;
use Membership\User\User;

class PostsController extends BaseController {

    /**
     * @var Blog\Post\Post
     */
    protected $posts;

    /**
     * @var Blog\Post\PostAlgorithm
     */
    protected $postAlgorithm;

    /**
     * @var Blog\Comment\Comment
     */
    protected $comments;

    /**
     * @var Membership\User\User
     */
    protected $users;

    /**
     * @var CommentAlgorithm
     */
    protected $commentAlgorithm;

    /**
     * @var Blog\Page\PageAlgorithm
     */
    protected $pageAlgorithm;

    /**
     * @param Post $posts
     * @param Blog\Post\PostAlgorithm $postAlgorithm
     * @param Comment $comments
     * @param Membership\User\User $users
     * @param CommentAlgorithm $commentAlgorithm
     * @param Blog\Page\PageAlgorithm $pageAlgorithm
     */
    public function __construct(Post $posts, PostAlgorithm $postAlgorithm, Comment $comments, User $users, CommentAlgorithm $commentAlgorithm, PageAlgorithm $pageAlgorithm )
    {
        $this->posts = $posts;
        $this->postAlgorithm = $postAlgorithm;
        $this->commentAlgorithm = $commentAlgorithm;
        $this->comments = $comments;
        $this->users = $users;
        $this->pageAlgorithm = $pageAlgorithm;
    }

    /**
     * @param string $slug
     * @param int $id
     * @return Response
     */
    public function show($slug, $id)
    {
        // Get post or fail
        $mainPost = $this->getPostOrFail($id);

        // This will remove page duplications
        if(! $mainPost->sameSlug($slug)) return Redirect::to(EasyURL::post($mainPost), 301);

        $postPage = $this->pageAlgorithm->byPost($mainPost)->order()->paginate(1);

        // Get the related tutorials
        $relatedPosts = $this->postAlgorithm->related( $mainPost )->postState()->get();

        // Get post parent and accepted comments
        $postComments = $this->commentAlgorithm->byPost($mainPost)->noParent()->accepted()->get();

        // Page title
        $pageTitle = $mainPost->getTitle();

        return View::make('posts.one', compact('mainPost', 'postPage', 'relatedPosts', 'postComments', 'pageTitle'));
    }

    /**
     * @param $slug
     * @param $id
     * @return mixed
     */
    public function addComment($slug, $id)
    {
        // Get current post
        $mainPost = $this->getPostOrFail($id);

        // Handle user creation by name and email
        $userInput['email'] = Input::get('User.email');

        if($user = $this->handleUserCreation($userInput)) {

            $user->setName(Input::get('User.name'));

            $user->save();

            // Create new instance and attach to main post
            $comment = $this->comments->newInstance(Input::get('Comment'))->attachTo($mainPost);

            // Attach it to user
            $user->comments()->save($comment);

            // Add errors if not valid
            if(! $comment->isValid()) $this->addErrors($comment);
        }

        return $this->chooseResponse("The comment has been added successfully and waiting to be accepted.");
    }

    /**
     * @param $id
     * @throws GeneralException
     * @return Post
     */
    protected function getPostOrFail($id)
    {
        $post = $this->posts->findOrFail($id);

        if(! $post->isPost()) throw new GeneralException("This post hasn't been published yet.");

        return $post;
    }
}