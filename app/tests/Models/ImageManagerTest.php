<?php namespace Models;

use Gallery\ImageManager;
use Illuminate\Database\Eloquent\Collection;
use Mockery;

class ImageManagerTest extends \TestCase {

    public function testUploadImages()
    {
        $imageUploader = Mockery::mock('\Intervention\Image\Image');
        $imageUploader->shouldReceive('save')->with('baseUri/profile/1/image.jpg')->times(1);

        $groupConfig = Mockery::mock('\Gallery\GroupConfig\GroupConfig');
        $groupConfig->shouldReceive('getUri')->times(1);
        $groupConfig->shouldReceive('manipulate')->with($imageUploader)->andReturn($imageUploader)->times(1);

        $imageGroup = Mockery::mock('\Gallery\ImageGroup\ImageGroup');
        $imageGroup->shouldReceive('getConfigs')->andReturn(new Collection(array(
            $groupConfig
        )));

        $path = Mockery::mock('PathManager\Path');
        $path->shouldReceive('makeSureItExists')->times(1);
        $path->shouldReceive('make')->andReturn('baseUri/profile/1/images.jpg')->times(1)->andReturn($path);
        $path->shouldReceive('__toString')->andReturn('baseUri/profile/1/image.jpg');

        $imageManager = new ImageManager($imageGroup, $path);

        $this->assertTrue($imageManager->upload($imageUploader, array(
            'user' => 1
        )));
    }

}