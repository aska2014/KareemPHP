<?php namespace Blog\Comment;

class Comment extends \BaseModel implements \AcceptableInterface, \PolymorphicInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'comments';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('commentable_id', 'commentable_type');

	/**
	 * The attributes that can't be mass assigned
	 *
	 * @var array
	 */
    protected $guarded = array('id', 'accepted', 'commentable_id', 'commentable_type', 'user_id');

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
        'description' => 'required',
        'user_id' => 'required|exists:users,id',
        'commentable' => 'polymorphic',
    );

    /**
     * For factoryMuff package to be able to fill attributes.
     *
     * @var array
     */
    public static $factory = array(

        'description' => 'text',
        'user_id' => 'factory|Membership\User\User'
    );

    /**
     * @param \BaseModel $model
     * @return mixed
     */
    public function attachTo( \BaseModel $model )
    {
        if(method_exists($model, 'comments')){

            return $model->comments()->save($model);
        }
    }

    /**
     * Accept current object.
     *
     * @return void
     */
    public function accept()
    {
        $this->accepted = true;

        $this->save();
    }

    /**
     * Un accept current object.
     *
     * @return void
     */
    public function unAccept()
    {
        $this->accepted = false;

        $this->save();
    }

    /**
     * Throws an exception if not accepted
     *
     * @throws NotAcceptedException
     * @return void
     */
    public function failIfNotAccepted()
    {
        if(! $this->accepted) {

            throw new NotAcceptedException;
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Membership\User\User');
    }
}