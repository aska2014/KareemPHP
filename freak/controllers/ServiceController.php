<?php

use Gallery\ImageFacade;

use core\Model;
use website\Service\Service;

use Membership\User\User;

class ServiceController extends AppController {

    protected $app;

	public function __construct(app\models\App\AppRepository $app)
	{
		parent::__construct(Model::get( 'Service' ));

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

		$services = Service::all();

		return View::make('services.data', compact('services'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$service = Service::find( $id );

		return View::make('services.detail', compact('service'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        Asset::addPlugins(array('wysiwyg','sheepit'));
		Asset::addPage('model_add');

		return View::make('services.add')->with('service', new EmptyClass);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return $this->create()->with('service', Service::find($id))->with('edit', true);
	}

	/**
	 * Validate resource before storing in storage
	 *
	 * @return Response
	 */
	public function validate()
	{
		$validator = Validator::make(Input::get('Service'), array(

            'title' => 'required'

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
		$service = new Service(Input::get('Service'));

        $service->save();

		return Response::json(array('insert_id' => $service->id, 'message' => 'success'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$service = Service::find($id);

        $service->update(Input::get('Service'));
		
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
        $service = Service::find($id);

        $boss = User::getBoss();

        if($mainFile = Input::file('main-image'))
            // Uploading main image
            $this->uploadMainImage($service, $boss, $mainFile);

        if($galleryFiles = Input::file('gallery-images'))
            // Uploading Gallery images
            $this->uploadGalleryImages($service, $boss, $galleryFiles);

        return $this->finishedUploading();
	}

    /**
     * @param Service $service
     * @param User $boss
     * @param $imageFile
     */
    private function uploadMainImage( Service $service, User $boss, $imageFile )
    {
        $versions = ImageFacade::versions('Service.Main', array('service' => $service->id), $imageFile);

        $image = $boss->images()->create(array(
            'title' => $service->title,
            'accepted' => true,
        ));

        $service->setMainImage($image->add($versions));
    }

    /**
     * @param Service $service
     * @param User $boss
     * @param $imageFiles
     */
    private function uploadGalleryImages(Service $service, User $boss, $imageFiles)
    {
        // Create gallery if it doesn't already exists
        if(! $service->galleryExists())
        {
            $boss->galleries()->create(array(

                'title' => $service->getTitle(),
                'description' => $service->getDescription()

            ))->attachTo($service);
        }

        foreach($imageFiles as $imageFile)
        {
            if(is_null($imageFile)) continue;

            $image = $boss->images()->create(array(
                'title' => $service->title,
                'accepted' => true,
            ));

            $versions = ImageFacade::versions('Service.Gallery', array('service' => $service->id, 'image' => $image->id), $imageFile);

            $service->addGalleryImage($image->add($versions));
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
		Service::find($id)->delete();
	
		return Redirect::back()->with('success', 'Service deleted successfully.');
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