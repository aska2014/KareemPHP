<?php

use website\Service\Service;

class ServicesController extends BaseController {

    /**
     * @var website\Service\Service
     */
    protected $services;

    /**
     * @param Service $services
     */
    public function __construct( Service $services )
    {
        $this->services = $services;
    }

    /**
     * @return Response
     */
    public function index()
    {
        $services = $this->services->all();

        return View::make('services.all', compact('services'));
    }

    /**
     * @param  int $id
     * @return Response
     */
    public function show( $id )
    {
        $mainService = $this->services->findOrFail($id);

        return View::make('services.one', compact('mainService'));
    }
}