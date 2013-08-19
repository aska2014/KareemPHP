<?php namespace Blog\Post;

use Gallery\Image\Image;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Membership\User\User;

class Post extends \BaseModel {

    /**
     * State constants
     */
    const DRAFT = 0;
    const POST = 1;
    const REVIEW = 2;

    /**
     * Difficulty constants
     */
    const BEGINNER = 0;
    const INTERMEDIATE = 1;
    const ADVANCED = 2;

    /**
     * The table name
     *
     * @var string
     */
    protected $table = 'posts';

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
    protected $softDelete = true;

    /**
     * Validations rules
     *
     * @var array
     */
    protected $rules = array(
        'title'   => 'required',
        'tags'    => 'required',
        'slug'    => 'required',
        'description' => 'required',
        'difficulty' => 'in:0,1,2',
        'user_id' => 'required|exists:users,id'
    );

    /**
     * For factoryMuff package to be able to fill the post attributes.
     *
     * @var array
     */
    public static $factory = array(

        'title' => 'string',
        'tags' => 'php,design,css',
        'description' => 'text',
        'slug' => 'string',
        'user_id' => 'factory|Membership\User\User'
    );

    /**
     * @return bool
     */
    public function isDraft()
    {
        return $this->state == self::DRAFT;
    }

    /**
     * @return bool
     */
    public function isPost()
    {
        return $this->state == self::POST;
    }

    /**
     * @return bool
     */
    public function isReview()
    {
        return $this->state == self::REVIEW;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return array
     */
    public static function getDifficulties()
    {
        return array(
            self::BEGINNER     => 'beginner',
            self::INTERMEDIATE => 'intermediate',
            self::ADVANCED     => 'advanced',
        );
    }

    /**
     * @return array
     */
    public static function getStates()
    {
        return array(
            self::DRAFT  => 'draft',
            self::POST   => 'post',
            self::REVIEW => 'review'
        );
    }

    /**
     * @return string
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @return string
     */
    public function getState()
    {
        $states = $this->getStates();

        return $states[$this->state];
    }

    /**
     * @return string
     */
    public function getDifficulty()
    {
        $difficulties = $this->getDifficulties();

        return $difficulties[$this->difficulty];
    }

    /**
     * @param string $format
     * @return string
     */
    public function getPostedAt( $format = '' )
    {
        if($format)
            return date($format, strtotime($this->posted_at));
        return $this->posted_at;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param $slug
     * @return bool
     */
    public function sameSlug($slug)
    {
        return $this->getSlug() == $slug;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlugAttribute( $slug )
    {
        $this->attributes['slug'] = Str::slug($slug);
    }

    /**
     * @param User $user
     * @return Post
     */
    public function copy( User $user )
    {
        $attributes = $this->getAttributes();

        unset($attributes['id']);

        // Create new post with the same attributes
        $newPost = $this->newInstance($attributes);

        // Save new post as a copy of this post.
        $this->copies()->save($newPost);

        // Set the new post user to the given user
        $user->posts()->save($newPost);

        // Copy old post pages to the new post
        foreach($this->pages as $page)
        {
            $page->copy($newPost);
        }

        return $newPost;
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
     * @param int $order
     * @return mixed
     */
    public function getPage( $order )
    {
        return $this->pages->getByOrder($order);
    }

    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model|mixed
     */
    public function attachDemo(array $attributes)
    {
        if($demo = $this->demo) {

            $demo->update($attributes);

            return $demo;
        }

        return $this->demo()->create($attributes);
    }

    /**
     * Create or update download
     *
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model|mixed
     */
    public function attachDownload(array $attributes)
    {
        if($download = $this->download) {

            $download->update($attributes);

            return $download;
        }

        return $this->download()->create($attributes);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function demo()
    {
        return $this->morphOne('Blog\Demo\Demo', 'demoable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function download()
    {
        return $this->morphOne('Blog\Download\Download', 'downloadable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function mainImage()
    {
        return $this->morphOne('Gallery\Image\Image', 'imageable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function copyOf()
    {
        return $this->belongsTo('Blog\Post\Post');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function copies()
    {
        return $this->hasMany('Blog\Post\Post', 'copy_of_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pages()
    {
        return $this->hasMany('Blog\Page\Page');
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    public function user()
    {
        return $this->belongsTo('Membership\User\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function rates()
    {
        return $this->morphMany('Blog\Rate\Rate', 'ratable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments()
    {
        return $this->morphMany('Blog\Comment\Comment', 'commentable');
    }
}