<?php

use Website\Place\Place;
use Website\Content\Content;
use Website\Page\Page;

use core\Model;

class ContentController extends AppController {

	public function __construct()
	{
		parent::__construct(Model::get( 'Content' ));
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Asset::addPlugin('datatables');

		$contents = Content::all();

		return View::make('contents.data', compact('contents'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$content = Content::find( $id );

		return View::make('contents.detail', compact('content'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		if(Place::all()->isEmpty()) {

			return Redirect::route('error-page')->with('errors', 'There is no place in your website yet to add content to.');
		}

		Asset::addPage('model_add');
		Asset::addPlugin('wysiwyg');

		return View::make('contents.add')->with('pages', Page::all())
										 ->with('places', Place::all())
										 ->with('content', new EmptyClass)
										 ->with('edit', false);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return $this->create()->with('content', Content::find($id));
	}

	/**
	 * Validate resource before storing in storage
	 *
	 * @return Response
	 */
	public function validate()
	{
		$validator = Validator::make(Input::get('Content'), array(

			'title' => 'required',
			'description' => 'required',
			'place' => 'required',

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
		$inputs = Input::get('Content');

		$content = Content::create(array(

			'title' => $inputs['title'],
			'description' => $inputs['description']

		));

		$place = Place::find($inputs['place']);

		$content->places()->save( $place );

		if($page = Page::find($inputs['page']))

			$page->places()->save( $place );


		else{

			$place->page_id = NULL;
			$place->save();
		}

		return Response::json(array('insert_id' => $content->id, 'message' => 'success'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$inputs = Input::get('Content');

		$content = Content::find($id);

		$content->title       = $inputs['title'];
		$content->description = $inputs['description'];

		$content->save();

		$place = Place::find($inputs['place']);

		$content->places()->save( $place );

		if($page = Page::find($inputs['page']))

			$page->places()->save( $place );


		else{

			$place->page_id = NULL;
			$place->save();
		}

		return Response::json(array('message' => 'success'));
	}

	/**
	 * Upload Image
	 *
	 * @param  int    $id
	 * @return Response
	 */
	public function upload( $id )
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Content::find($id)->delete();

		return Redirect::back()->with('success', 'Content deleted successfully.');
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