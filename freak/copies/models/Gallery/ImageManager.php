<?php namespace Gallery;

use Gallery\GroupSpec\GroupSpec;
use Gallery\Group\Group;
use Intervention\Image\Image as ImageUploader;
use PathManager\Path;

class ImageManager {

    /**
     * @var Group\ImageGroup
     */
    protected $imageGroup;

    /**
     * @var \PathManager\Path
     */
    protected $path;

    /**
     * @param Group $imageGroup
     * @param \PathManager\Path $path Base path
     */
    public function __construct(Group $imageGroup, Path $path)
    {
        $this->imageGroup = $imageGroup;
        $this->path       = $path;
    }

    /**
     * @param ImageUploader $imageUploader
     * @param array $replacers
     * @param GroupSpec $groupConfig
     * @return bool
     */
    public function upload(ImageUploader $imageUploader, array $replacers = array(), GroupSpec $groupConfig = null)
    {
        if(! is_null($groupConfig))

            return $this->uploadOneConfig($imageUploader, $replacers, $groupConfig);

        return $this->uploadAllConfigs($imageUploader, $replacers);
    }

    /**
     * @param ImageUploader $imageUploader
     * @param array $replacers
     * @param GroupSpec $groupConfig
     * @return bool
     */
    protected function uploadOneConfig(ImageUploader $imageUploader, array $replacers = array(), GroupSpec $groupConfig)
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