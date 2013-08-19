<?php

use Blog\Post\Post;
use Gallery\Image\Image;
use Gallery\ImageFacade;
use Membership\User\User;
use PathManager\Path;
use core\Model;

class PostController extends AppController {

    protected $app;

    public function __construct( app\models\App\AppRepository $app )
	{
		parent::__construct(Model::get( 'Post' ));

        $this->app = $app;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Asset::addPlugin('datatables');

		$posts = Post::all();

        $baseUrl = $this->app->host->getBaseUrl();

		return View::make('posts.data', compact('posts', 'baseUrl'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$post = Post::find( $id );

        $baseUrl = $this->app->host->getBaseUrl();

        return View::make('posts.detail', compact('post', 'baseUrl'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		Asset::addPage('model_add');
        Asset::addPlugin('picker');

        $baseUrl = $this->app->host->getBaseUrl();

        $difficulties = Post::getDifficulties();
        $postStates    = Post::getStates();

		return View::make('posts.add')->with('post', new EmptyClass)
                                      ->with('baseUrl', $baseUrl)
                                      ->with('difficulties', $difficulties)
                                      ->with('postStates',   $postStates);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return $this->create()->with('post', Post::find($id))->with('edit', true);
	}

	/**
	 * Validate resource before storing in storage
	 *
	 * @return Response
	 */
	public function validate()
	{
        $validator = Validator::make(Input::get('Post'), array(
            'slug' => 'required',
            'title' => 'required',
            'difficulty' => 'required',
            'description' => 'required'
        ));

		if($validator->fails())
		
			return Response::json(array( 'message' => 'failed', 'body' => $validator->messages()->all(':message')));

		else

			return Response::json(array( 'message' => 'success', 'body' => 'Inputs are validated successfully'));

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $this->editPostedAtDate();

		$post = new Post(Input::get('Post'));

        User::getBoss()->posts()->save($post);

		return Response::json(array('insert_id' => $post->id, 'message' => 'success'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $this->editPostedAtDate();

		$post = Post::find($id);

        $post->update(Input::get('Post'));

        if(Input::get('use_download')) {

            $post->attachDownload(Input::get('Download'));
        } else {

            $post->download()->delete();
        }

        if(Input::get('use_demo')) {

            $post->attachDemo(Input::get('Demo'));
        } else {

            $post->demo()->delete();
        }


		return Response::json(array('message' => 'success'));
	}

    /**
     * Edit posted_at input
     */
    private function editPostedAtDate()
    {
        $inputs = Input::all();

        $inputs['Post']['posted_at'] = date('Y-m-d H:i:s', strtotime(Input::get('Post.posted_at')));

        Input::replace($inputs);
    }

	/**
	 * Upload Image
	 *
	 * @param  int    $id
	 * @return Response
	 */
	public function upload( $id )
	{
        $post = Post::find($id);

        $this->uploadPostMainImage($post, Input::file('main-image'));

        $this->uploadDemoZipFile($post, Input::file('demo-zip'));

        return $this->finishedUploading();
	}

    /**
     * @param Post $post
     * @param $zipFile
     */
    protected function uploadDemoZipFile(Post $post, $zipFile)
    {
        if(! $zipFile) return;

        $destination = Path::make($this->app->host->getBasePath() . '/demos/' . $post->id);

        if($this->unZipFile($zipFile->getRealPath(), $destination))
        {
            $post->attachDemo(array('link' => $destination->toUrl()));
        }
    }

    /**
     * @param $source
     * @param $destination
     * @return bool
     */
    protected function unZipFile( $source, Path $destination )
    {
        $zip = new ZipArchive;
        $res = $zip->open($source);

        if ($res === TRUE) {

            $destination->makeSureItExists();

            $zip->extractTo((string) $destination);
            $zip->close();

            return true;
        }

        return false;
    }

    /**
     * @param Post $post
     * @param $imageFile
     */
    protected function uploadPostMainImage(Post $post, $imageFile)
    {
        if($imageFile)
        {
            $versions = ImageFacade::versions('Post.Main', array('post' => $post->id), $imageFile);

            $image = User::getBoss()->images()->create(array(
                'title' => $post->getTitle(),
                'accepted' => true,
            ))->add($versions);

            $post->setMainImage($image);
        }
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Post::find($id)->delete();
	
		return Redirect::back()->with('success', 'Post deleted successfully.');
	}

	/**
	 * Destroy images from storage
	 * 
	 * @param  int  $id
	 * @return Response
	 */
	public function destroyImages( $id )
	{

	}

}