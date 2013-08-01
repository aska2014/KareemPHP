<?php namespace Gallery\GroupSpec;

use Helpers\Helper;

class GroupSpec extends \BaseModel {
	protected $connection = 'server';
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'image_group_specs';

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
        'image_group_id' => 'factory|Gallery\Group\Group'
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
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function operations()
    {
        return $this->morphMany('Core\Operation\Operation', 'operable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo('Gallery\Group\Group', 'image_group_id');
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