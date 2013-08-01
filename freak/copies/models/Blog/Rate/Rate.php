<?php namespace Blog\Rate;

class Rate extends \BaseModel implements \PolymorphicInterface {
	protected $connection = 'server';
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'rates';

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

        'user_id' => 'required|exists:users,id',
        'percentage' => 'required|integer|max:100|min:0',
        'ratable' => 'polymorphic'
    );

    /**
     * For factoryMuff package to be able to fill attributes.
     *
     * @var array
     */
    public static $factory = array(
        'user_id' => 'factory|Membership\User\User',
        'percentage' => '30',
    );

    /**
     * Will return the saved object if success.
     *
     * @param \BaseModel $model
     * @return Rate|null|false
     */
    public function attachTo( \BaseModel $model )
    {
        if(method_exists($model, 'rates'))

            return $model->rates()->save($this);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Membership\User\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ratable()
    {
        return $this->morphTo();
    }

}