<?php namespace core\Operation;

class Operation extends \BaseModel {

    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'operations';

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
        'type'   => 'required',
        'method' => 'required',
        'group_config_id' => 'required|exists:group_configs,id'
    );

    /**
     * @var array
     */
    public static $factory = array(
        'type'   => '\Intervention\Image\Image',
        'method' => 'string',
        'args'   => 'arg1,arg2,arg3',
        'group_config_id' => 'factory|Gallery\GroupConfig\GroupConfig'
    );

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getArguments()
    {
        if($this->args == '') return array();

        return explode(',', $this->args);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function groupConfig()
    {
        return $this->belongsTo('Gallery\GroupConfig\GroupConfig', 'group_config_id');
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param $object
     * @return mixed
     */
    public function call($object)
    {
        $type = $this->getType();

        if($object instanceof $type) {

            return call_user_func_array(array($object, $this->getMethod()), $this->getArguments());
        }
    }
}