<?php

use Website\Page\Page;
use core\Model;

class PageController extends AppController {

	public function __construct()
	{
		parent::__construct(Model::get( 'Page' ));
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		Asset::addPlugin('datatables');

		$pages = Page::all();

        $baseUrl = App::make('app\models\Host\HostRepository')->getBaseUrl();

		return View::make('pages.data', compact('pages', 'baseUrl'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$page = Page::find( $id );

		$baseUrl = App::make('app\models\Host\HostRepository')->getBaseUrl();

		return View::make('pages.detail', compact('page', 'baseUrl'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		Asset::addPage('model_add');
		Asset::addPlugins(array('ckeditor', 'form'));

		return View::make('pages.add')->with('page', new EmptyClass)->with('parentPages', Page::all())
									  ->with('baseUrl', App::make('app\models\Host\HostRepository')->getBaseUrl() . '/');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return $this->create()->with('page', Page::find($id));
	}

	/**
	 * Validate resource before storing in storage
	 *
	 * @return Response
	 */
	public function validate()
	{
		$validator = Validator::make(Input::get('Page'), array(

			'title' => 'required',
			'slug'   => 'required',
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
		$inputs = Input::get('Page');

		$page = Page::create(array(

			'slug'          => $inputs['slug'],
			'title'         => $inputs['title'],
			'description'   => $inputs['description'],
            'show_in_menu'  => $inputs['show_in_menu']

		));

		if($inputs['parent']) $page->parent()->associate(Page::find($inputs['parent']))->save();
		else {
			$page->parent_id = null;
			$page->save();
		}

		return Response::json(array('insert_id' => $page->id, 'message' => 'success'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$inputs = Input::get('Page');

		$page = Page::find($id);

		$page->update(array(

			'slug'          => $inputs['slug'],
			'title'         => $inputs['title'],
			'description'   => $inputs['description'],
            'show_in_menu'  => $inputs['show_in_menu']

		));

		if($inputs['parent']) $page->parent()->associate(Page::find($inputs['parent']))->save();
		else {
			$page->parent_id = null;
			$page->save();
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
		Page::find($id)->delete();
		
		return Redirect::back()->with('success', 'Deleted successfully');
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