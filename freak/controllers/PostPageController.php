<?php

use Blog\Page\Page;
use Blog\Post\Post;
use core\Model;

class PostPageController extends AppController {

    protected $app;

	public function __construct(app\models\App\AppRepository $app)
	{
		parent::__construct(Model::get( 'PostPage' ));

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

		$postpages = Page::all();

		return View::make('postpages.data', compact('postpages'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$postpage = Page::find( $id );

		return View::make('postpages.detail', compact('postpage'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        Asset::addPlugins(array('ckeditor', 'form', 'syntax', 'hotkeys'));
		Asset::addPage('model_add');

		return View::make('postpages.add')->with('postpage', new EmptyClass)
                                          ->with('posts', Post::all());
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return $this->create()->with('postpage', Page::find($id))->with('edit', true);
	}

	/**
	 * Validate resource before storing in storage
	 *
	 * @return Response
	 */
	public function validate()
	{
		$validator = Validator::make(Input::get('PostPage'), array(

            'body' => 'required',
            'post_id' => 'required',

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
		$postpage = new Page(Input::get('PostPage'));

        $postpage->save();

        return Redirect::action('PostPageController@edit', $postpage->id)->with('success', 'Congratulation');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$postpage = Page::find($id);

        $inputs = Input::get('PostPage');
        $inputs['body'] = htmlentities($inputs['body']);

        $postpage->update($inputs);

        return Redirect::action('PostPageController@edit', $postpage->id)->with('success', 'Congratulation');
	}

	/**
	 * Upload Image
	 *
	 * @param  int    $id
	 * @return string
	 */
	public function upload( $id )
	{
		// Upload normal images
        if($image = Input::file('normal-image'))
        {
            return $this->uploadNormalImage($image);
        }
	}

    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $image
     * @return string
     */
    public function uploadNormalImage( \Symfony\Component\HttpFoundation\File\UploadedFile $image )
    {
        $public = $this->app->host->getBasePath();

        $destination = $public . '/albums/images/';

        $imageName = $image->getClientOriginalName();

        while(file_exists($destination . $imageName)) {

            $imageName = rand(0, 9) . $imageName;
        }

        $image->move($destination, $imageName);

        return $this->app->host->getBaseUrl() . '/albums/images/' . $imageName;
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $page = Page::find($id);

        $post = $page->post;

        $page->delete();

		return Redirect::action('PostController@edit', $post->id)->with('success', 'PostPage deleted successfully.');
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