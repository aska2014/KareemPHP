<?php namespace Membership\User;

use Blog\Post\Post;
use Gallery\Image\Image;
use Helpers\Helper;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Hashing\BcryptHasher;
use NotAcceptedException;

class User extends \BaseModel implements UserInterface, RemindableInterface, \AcceptableInterface {

    /**
     * Users types
     */
    const VISITOR = 0;
    const NORMAL = 1;
    const ADMINISTRATOR = 9;
    const DEVELOPER = 10;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password');

    /**
     * @var array
     */
    protected $guard = array('id', 'password', 'type');

    /**
     * Force validation of this model
     *
     * @var boolean
     */
    protected $forceValidation = true;

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = array(
        'username' => 'required|min:6',
        'email'    => 'required|email',
        'password' => 'required|regex:((?=.*\d)(?=.*[a-z]).{8,20})',
        'ip'       => 'required|ip',
        'type'     => 'in:0,1,9,10'
    );

    /**
     * @var array
     */
    protected $customMessages = array(
        'password.regex' => 'Password must be from 8 to 20 characters and contain at least 1 digit'
    );

    /**
     * For factoryMuff package to be able to fill the post attributes.
     *
     * @var array
     */
    public static $factory = array(

        'username' => 'kareem3d',
        'email' => 'email',
        'password' => 'kareem123',

    );

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
     * @return \Illuminate\Hashing\HasherInterface
     */
    public function getHasher()
    {
        return new BcryptHasher();
    }

    /**
     * @return void
     */
    public function beforeValidate()
    {
        // Clean from XSS attach
        $this->cleanXSS();

        // Update user IP.
        $this->makeIP();
    }

    /**
     * @param string $checkPassword
     * @return bool
     */
    public function checkPassword( $checkPassword )
    {
        return $this->getHasher()->check($checkPassword, $this->password);
    }

    /**
     * @return void
     */
    public function makePassword()
    {
        $this->password = $this->getHasher()->make($this->password);
    }

    /**
     * @return void
     */
    public function beforeSave()
    {
        // If password is dirty which means it did change
        if($this->isDirty('password')) {

            $this->makePassword();
        }
    }

    /**
     * @return void
     */
    public function makeIP()
    {
        $this->ip = Helper::instance()->getCurrentIP();
    }

    /**
     * @param Post $post
     * @return bool
     */
    public function hasPost( Post $post )
    {
        return $this->posts()->where('id', $post->id)->count() > 0;
    }

    /**
     * @return bool
     */
    public function isAdministrator()
    {
        return $this->type == self::ADMINISTRATOR;
    }

    /**
     * @return bool
     */
    public function isDeveloper()
    {
        return $this->type == self::DEVELOPER;
    }

    /**
     * @return bool
     */
    public function isVisitor()
    {
        return $this->type == self::VISITOR;
    }

    /**
     * @return bool
     */
    public function isNormal()
    {
        return $this->type == self::NORMAL;
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }

    /**
     * @param Image $image
     * @return mixed
     */
    public function setProfileImage( Image $image )
    {
        return $this->profileImage()->save($image);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function profileImage()
    {
        return $this->morphOne('Gallery\Image\Image', 'imageable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany('Gallery\Image\Image');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany('Blog\Post\Post');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rates()
    {
        return $this->hasMany('Blog\Rate\Rate');
    }
}