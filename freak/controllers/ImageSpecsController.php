<?php

use Gallery\Group\Group;
use core\Model;
use core\Operation\Operation;

class ImageSpecsController extends AppController {

    protected $app;

	public function __construct(app\models\App\AppRepository $app)
	{
		parent::__construct(Model::get( 'ImageSpecs' ));

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

        $imageGroups = Group::all();

        return View::make('imagespecs.data', compact('imageGroups'));
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$imageGroup = Group::find( $id );

		return View::make('imagespecs.detail', compact('imageGroup'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		Asset::addPage('model_add');
        Asset::addPlugins(array('sheepit'));

        return View::make('imagespecs.add');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $imageGroup = Group::find( $id );

        return $this->create()->with('imageGroup', $imageGroup);
	}

	/**
	 * Validate resource before storing in storage
	 *
	 * @return Response
	 */
	public function validate()
	{
		$validator = Validator::make(Input::get('ImageSpecs'), array(

			// Validations

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
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $specs = Input::get('ImageSpecs');

        $group = Group::find($id);

        // Delete all specifications with their operations first
        foreach($group->specs as $dbSpec)
        {
            $dbSpec->operations()->delete();
            $dbSpec->delete();
        }

        foreach($specs as $spec)
        {
            if($spec['uri'] == '') continue;

            $dbSpec = $group->specs()->create(array(
                'uri' => $spec['uri']
            ));

            $operations = explode(';', $spec['operations']);

            foreach($operations as $operation)
            {
                if($operation == '') continue;

                Operation::createFromCodeFormat($operation)->attachTo($dbSpec);
            }
        }

        return Redirect::back()->with('success', 'Inserted successfully.');
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
		ImageSpecs::find($id)->delete();
	
		return Redirect::back()->with('success', 'ImageSpecs deleted successfully.');
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