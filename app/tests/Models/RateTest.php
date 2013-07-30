<?php namespace Models;

class RateTest extends \TestCase {

    public function testMustBeAttachedToUser()
    {
        $rate = $this->factory->instance('Blog\Rate\Rate', array('user_id' => 0));

        $this->assertFalse($rate->save());

        $rate = $this->factory->instance('Blog\Rate\Rate');

        $this->assertNotNull($rate->user);
    }

    public function testMustBeAttachedToModel()
    {
        $post = $this->factory->create('Blog\Post\Post');
        $rate = $this->factory->instance('Blog\Rate\Rate');

        $this->assertFalse($rate->save());

        $this->assertTrue(!! $rate->attachTo($post));

        $this->assertTrue($rate->validate());

        $this->assertNotNull($rate->ratable);

        $this->assertTrue($rate->ratable instanceof \Blog\Post\Post);
    }
}