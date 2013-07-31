<?php namespace Gallery;

use Gallery\GroupConfig\GroupConfig;
use Gallery\ImageGroup\ImageGroup;
use Intervention\Image\Image as ImageUploader;
use PathManager\Path;

class ImageManager {

    /**
     * @var ImageGroup\ImageGroup
     */
    protected $imageGroup;

    /**
     * @var \PathManager\Path
     */
    protected $path;

    /**
     * @param ImageGroup $imageGroup
     * @param \PathManager\Path $path Base path
     */
    public function __construct(ImageGroup $imageGroup, Path $path)
    {
        $this->imageGroup = $imageGroup;
        $this->path       = $path;
    }

    /**
     * @param ImageUploader $imageUploader
     * @param array $replacers
     * @param GroupConfig $groupConfig
     * @return bool
     */
    public function upload(ImageUploader $imageUploader, array $replacers = array(), GroupConfig $groupConfig = null)
    {
        if(! is_null($groupConfig))

            return $this->uploadOneConfig($imageUploader, $replacers, $groupConfig);

        return $this->uploadAllConfigs($imageUploader, $replacers);
    }

    /**
     * @param ImageUploader $imageUploader
     * @param array $replacers
     * @param GroupConfig $groupConfig
     * @return bool
     */
    protected function uploadOneConfig(ImageUploader $imageUploader, array $replacers = array(), GroupConfig $groupConfig)
    {
        $uri = $groupConfig->getUri($replacers);

        $destination = $this->path->make((string) $this->path . $uri);

        $destination->makeSureItExists();

        $groupConfig->manipulate($imageUploader)->save((string) $destination);

        return true;
    }

    /**
     * @param ImageUploader $imageUploader
     * @param array $replacers
     * @return bool
     */
    protected function uploadAllConfigs(ImageUploader $imageUploader, array $replacers = array())
    {
        foreach($this->imageGroup->getConfigs() as $groupConfig)
        {
            $this->uploadOneConfig($imageUploader, $replacers, $groupConfig);
        }

        return true;
    }
}