<?php namespace Blog\Comment;

use Illuminate\Database\Eloquent\Collection;

class Comment extends \BaseModel implements \PolymorphicInterface {

    /**
     * @var array
     */
    protected $uses = array('Acceptable');

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
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param \BaseModel $model
     * @return Comment
     */
    public function attachTo( \BaseModel $model )
    {
        if(method_exists($model, 'comments')){

            $model->comments()->save($this);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getAcceptedReplies()
    {
        return $this->replies()->where('accepted', true)->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function commentable()
    {
        return $this->morphTo();
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
    public function parent()
    {
        return $this->belongsTo('Blog\Comment\Comment', 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany('Blog\Comment\Comment', 'parent_id');
    }
}