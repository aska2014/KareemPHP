<?php

namespace Models\Blog;

use Blog\Page\Page;
use Blog\Post\Post;
use Membership\User\User;
use Zizaco\FactoryMuff\FactoryMuff;

class PostTest extends \TestCase {

    public function testCanCreatePostAttachedToUser()
    {
        $post = $this->factory->create('Blog\Post\Post');

        $this->assertNotNull($post);
        $this->assertNotNull($post->user);
        $this->assertNotEmpty($post->user->posts);

        $this->assertEquals($post->id, $post->user->posts[0]->id);
    }

    public function testValidatingPostBeforeSaving()
    {
        $post = new Post(array());

        $this->assertFalse($post->save());

        // Fill with a null user id
        $post->fill($this->factory->attributesFor('Blog\Post\Post', array('user_id' => 0)));

        $this->assertFalse($post->save(array('test')), $this->showValidationMessages($post));

        // Enter a non existing user id.
        $post->user_id = 165454651;

        $this->assertFalse($post->save());

        if(!$user = User::query()->first()) {

            $user = $this->factory->create('Membership\User\User');
        }

        $post->user_id = $user->id;

        $this->assertTrue($post->save(), implode(PHP_EOL, $post->getValidator()->messages()->all(':message')));

        $this->assertTrue($user->hasPost( $post ));
    }

    public function testAutomaticModifyOfSlugAttribute()
    {
        $post = new Post(array(
            'slug' => 'bla bla bla bla'
        ));

        // If not equals that means it's modified
        $this->assertNotEquals($post->slug, 'bla bla bla bla');

        $this->assertEquals(str_word_count($post->slug), 4);
    }

    public function testCreatingPostPages()
    {
        $post = $this->factory->create('Blog\Post\Post');

        $post->pages()->create(array(
           'body' => 'This is page 1'
        ));
        $post->pages()->create(array(
            'body' => 'This is page 2'
        ));

        $this->assertEquals($post->pages->count(), 2);

        $this->assertEquals($post->pages[0]->body, 'This is page 1');
        $this->assertEquals($post->pages[1]->body, 'This is page 2');

        return $post;
    }

    /**
     * @depends testCreatingPostPages
     */
    public function testCopyPost( Post $oldPost )
    {
        $newUser = $this->factory->create('Membership\User\User');

        $pagesNumber = Page::all()->count();

        $newPost = $oldPost->copy( $newUser );

        $this->assertNotNull($newPost);

        $this->assertEquals($oldPost->title, $newPost->title);
        $this->assertEquals($oldPost->difficulty, $newPost->difficulty);
        $this->assertEquals($oldPost->tags, $newPost->tags);

        $this->assertEquals($newPost->user->id, $newUser->id);

        $this->assertEquals($newPost->copyOf->id, $oldPost->id);
        $this->assertEquals($oldPost->copies->count(), 1);
        $this->assertEquals($oldPost->copies[0]->id, $newPost->id);

        $this->assertEquals($newPost->pages->count(), $oldPost->pages->count());
        // Asset that number of old pages + new post pages are equal to the number of new pages
        $this->assertEquals($pagesNumber + $newPost->pages->count(), Page::all()->count());
    }

    public function testMainImage()
    {
        $post = $this->factory->create('Blog\Post\Post');

        $post->setMainImage($this->factory->create('Gallery\Image\Image'));

        $this->assertTrue($post->mainImage instanceof \Gallery\Image\Image);
    }
}