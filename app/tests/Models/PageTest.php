<?php namespace Models;

use Blog\Post\Post;
use Blog\Page\Page;

class PageTest extends \TestCase {

    public function testBelongsToPost()
    {
        $page = $this->factory->create('Blog\Page\Page');

        $this->assertTrue($page->post instanceof Post);
    }


    public function testCopyPage()
    {
        $oldPage = $this->factory->create('Blog\Page\Page');
        $newPost = $this->factory->create('Blog\Post\Post');

        $newPage = $oldPage->copy( $newPost );

        $this->assertNotNull( $newPost );

        $this->assertEquals($newPage->post->id, $newPost->id);
        $this->assertEquals($oldPage->body, $newPage->body);
    }


}