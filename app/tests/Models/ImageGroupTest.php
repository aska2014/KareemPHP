<?php namespace Models;

class ImageGroupTest extends \TestCase {

    public function testCreateNewImageGroup()
    {
        $imageGroup = $this->factory->create('Gallery\ImageGroup\ImageGroup');

        $this->assertNotNull($imageGroup);

        return $imageGroup;
    }

    public function testHasManyGroupConfigs()
    {
        $imageGroup = $this->testCreateNewImageGroup();

        $imageGroup->configs()->create(array(
            'uri' => 'users/profile/{user}/image.jpg'
        ));

        $imageGroup->configs()->create(array(
            'uri' => 'users/profile/{user}/image.jpg'
        ));

        $this->assertEquals(2, $imageGroup->configs->count());
    }
}