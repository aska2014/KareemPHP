<?php namespace Blog\Page;

use Blog\Post\Post;

class Page extends \BaseModel implements \OrderedInterface {

    use \Ordered;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'postpages';

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

        'body' => 'required',
        'post_id' => 'required|exists:posts,id'

    );

    /**
     * For factoryMuff package to be able to fill attributes.
     *
     * @var array
     */
    public static $factory = array(

        'body' => 'text',
        'post_id' => 'factory|Blog\Post\Post'
    );

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function getReadyBody()
    {
        return html_entity_decode($this->getBody());
    }

    /**
     * @return Builder
     */
    public function getOrderGroup()
    {
        return $this->query()->where('post_id', $this->post_id);
    }

    /**
     * @param Post $post
     * @return Page
     */
    public function copy( Post $post )
    {
        $attributes = $this->getAttributes();

        unset($attributes['id']);

        // Create new post with the same attributes
        $newPage = $this->newInstance($attributes);

        // Save new post as a copy of this post.
        $post->pages()->save($newPage);

        return $newPage;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo('Blog\Post\Post');
    }
}