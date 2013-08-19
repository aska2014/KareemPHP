<?php

use PathManager\Path;

ClassLoader::addDirectories(array(

	__DIR__ . '/../copies/models',
	__DIR__ . '/../copies/libraries'

));


require __DIR__ . '/../../app/bindings.php';

$host = App::make('app\models\App\AppRepository')->host;

// Initialize Path class
Path::init($host->getBaseUrl(), $host->getBasePath());

BaseModel::turnOffValidations();

// Delete image route
Route::get('delete-images/{id}', array('as' => 'delete-image', function($id)
{
    \Gallery\Image\Image::find($id)->delete();

    return Redirect::back()->with('success', 'Image has been deleted successfully.');
}))->where('id', '[0-9]+');