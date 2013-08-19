<?php

use Blog\Download\Download;

class DownloadsController extends BaseController {

    /**
     * @var Blog\Download\Download
     */
    protected $downloads;

    /**
     * @param Download $downloads
     */
    public function __construct(Download $downloads)
    {
        $this->downloads = $downloads;
    }

    /**
     * @param int $id
     * @return Response
     */
    public function redirect( $id )
    {
        $download = $this->downloads->findOrFail($id);

        $download->incrementNumberOfDownloads();

        return Redirect::to($download->getLink());
    }
}