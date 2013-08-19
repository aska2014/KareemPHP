<?php namespace website\Service;

use Gallery\Image\Image;

class Service extends \BaseModel {
	protected $connection = 'server';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'services';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array();

    /**
     * The attributes that can't be mass assigned
     *
     * @var array
     */
    protected $guarded = array('id');

    /**
     * Whether or not to softDelete
     *
     * @var bool
     */
    protected $softDelete = false;

    /**
     * Validations rules
     *
     * @var array
     */
    protected $rules = array(
        'title' => 'required',
    );

    /**
     * For factoryMuff package to be able to fill attributes.
     *
     * @var array
     */
    public static $factory = array(
        'title'       => 'string',
        'description' => 'text'
    );

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return bool
     */
    public function galleryExists()
    {
        return $this->gallery()->count() > 0;
    }

    /**
     * @param Image $image
     */
    public function addGalleryImage( Image $image )
    {
        $this->gallery->images()->save($image);
    }

    /**
     * @return Image
     */
    public function getMainImage()
    {
        return $this->mainImage;
    }

    /**
     * @param Image $image
     * @return $this
     */
    public function setMainImage( Image $image )
    {
        if($mainImage = $this->getMainImage())

            $image->override($mainImage);

        return $this->mainImage()->save($image);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function mainImage()
    {
        return $this->morphOne('Gallery\Image\Image', 'imageable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function gallery()
    {
        return $this->morphOne('Gallery\Gallery\Gallery', 'gallerable');
    }
}