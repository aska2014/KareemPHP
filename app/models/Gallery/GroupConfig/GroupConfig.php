<?php namespace Gallery\GroupConfig;

use Helpers\Helper;

class GroupConfig extends \BaseModel {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'group_configs';

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
        'image_group_id' => 'required|exists:image_groups,id'
    );

    /**
     * For factoryMuff package to be able to fill attributes.
     *
     * @var array
     */
    public static $factory = array(
        'uri' => 'string',
        'image_group_id' => 'factory|Gallery\ImageGroup\ImageGroup'
    );

    /**
     * @param array $replacers
     * @return string
     */
    public function getUri(array $replacers = array())
    {
        return Helper::instance()->replaceAll($this->uri, $replacers);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function operations()
    {
        return $this->hasMany('Core\Operation\Operation');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function imageGroup()
    {
        return $this->belongsTo('Gallery\ImageGroup\ImageGroup', 'image_group_id');
    }

    /**
     * @param $object
     * @return mixed
     */
    public function manipulate($object)
    {
        foreach($this->operations as $operation)
        {
            $operation->call($object);
        }

        return $object;
    }
}