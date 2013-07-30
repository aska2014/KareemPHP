<?php namespace Models;

use Gallery\Image\Image;
use Gallery\Version\Version;
use Mockery;

class ImageTest extends \TestCase {

    private function createVersion()
    {
        return $this->factory->instance('Gallery\Version\Version', array(
            'image_id' => 0
        ));
    }

    /**
     * @expectedException \Zizaco\FactoryMuff\SaveException
     */
    public function testImageMustBeCreatedByValidUser()
    {
        $this->factory->create('Gallery\Image\Image',array(
            'user_id' => 652542
        ));
    }

    public function testAddingOneVersion()
    {
        $image = $this->factory->create('Gallery\Image\Image');

        $version = $this->createVersion();

        $image->add($version);

        $this->assertTrue($image->versions[0]->url == $version->url);
    }

    public function testAddingManyVersions()
    {
        $image = $this->factory->create('Gallery\Image\Image');

        $image->add(array($this->createVersion(), $this->createVersion(), $this->createVersion()));

        $this->assertTrue($image->versions->count() == 3);

        return $image;
    }

    public function testVersionExistsForThisImage()
    {
        $image = $this->factory->create('Gallery\Image\Image');

        $this->assertFalse($image->exists());

        $image->add($this->createVersion());

        $this->assertTrue($image->exists());
    }

    public function testGetVersionFromDimensions()
    {
        $image = $this->factory->create('Gallery\Image\Image');

        $image->add($this->createVersion());

        $versionAlgorithm = Mockery::mock('\Gallery\Version\VersionAlgorithm');
        $versionAlgorithm->shouldReceive('nearestDim')->times(1)->andReturn($image->versions());
        $versionAlgorithm->shouldReceive('smallestDim')->times(1)->andReturn($image->versions());
        $versionAlgorithm->shouldReceive('largestDim')->times(1)->andReturn($image->versions());

        $image->setVersionAlgorithm($versionAlgorithm);

        $this->assertTrue($image->getNearest(120, 120) instanceof \Gallery\Version\Version);
        $this->assertTrue($image->getSmallest()        instanceof \Gallery\Version\Version);
        $this->assertTrue($image->getLargest()         instanceof \Gallery\Version\Version);
    }
}