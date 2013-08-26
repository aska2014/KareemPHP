<?php namespace Models\Blog;

use Blog\Comment\Comment;
use Membership\User\User;

class CommentTest extends \TestCase {

    public function testCommentMustBeAttachedToModel()
    {
        $comment = $this->factory->instance('Blog\Comment\Comment');

        $this->assertNotNull($comment->user);

        $this->assertTrue($comment->user instanceof User);

        $this->assertFalse($comment->save());
    }
}