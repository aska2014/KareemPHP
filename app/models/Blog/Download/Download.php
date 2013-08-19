<?php namespace Blog\Download;

class Download extends \BaseModel {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'downloads';

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
        'link' => 'required|url'
    );

    /**
     * For factoryMuff package to be able to fill attributes.
     *
     * @var array
     */
    public static $factory = array(
        'link' => 'string'
    );

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @return void
     */
    public function incrementNumberOfDownloads()
    {
        $this->number_of_downloads ++;

        $this->save();
    }

    /**
     * @return integer
     */
    public function getNumberOfDownloads()
    {
        return $this->number_of_downloads;
    }

    /**
     * @param \BaseModel $model
     * @return $this
     */
    public function attachTo(\BaseModel $model)
    {
        $this->demoable_type = get_class($model);
        $this->demoable_id = $model->id;

        $this->save();

        return $this;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function downloadable()
    {
        return $this->morphTo();
    }
}