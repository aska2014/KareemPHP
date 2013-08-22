<?php

use website\Service\Service;
use website\Service\ServiceAlgorithm;

class ServicesController extends BaseController {

    /**
     * @var website\Service\ServiceAlgorithm
     */
    protected $servicesAlgorithm;

    /**
     * @var website\Service\Service
     */
    protected $services;

    /**
     * @param website\Service\ServiceAlgorithm $servicesAlgorithm
     * @param website\Service\Service $services
     */
    public function __construct( ServiceAlgorithm $servicesAlgorithm, Service $services )
    {
        $this->servicesAlgorithm = $servicesAlgorithm;
        $this->services = $services;
    }

    /**
     * @return Response
     */
    public function index()
    {
        $services = $this->servicesAlgorithm->order()->get();

        $pageTitle = 'Web development and design services.';

        return View::make('services.all', compact('services', 'pageTitle'));
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