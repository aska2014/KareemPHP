<?php

use Zizaco\FactoryMuff\FactoryMuff;

class TestCase extends Illuminate\Foundation\Testing\TestCase {

    public function __construct()
    {
        $this->factory = new FactoryMuff();
    }

    public function setUp()
    {
        // I forgot to call the parent setUp method
        parent::setUp();

        Mail::pretend();

        // We first have to set up the database with our migrations..
        $this->setUpDB();
    }

    public function tearDown()
    {
        Mockery::close();
    }

	/**
	 * Creates the application.
	 *
	 * @return Symfony\Component\HttpKernel\HttpKernelInterface
	 */
	public function createApplication()
	{
		$unitTesting = true;

		$testEnvironment = 'testing';

		return require __DIR__.'/../../bootstrap/start.php';
	}

    private function setUpDB()
    {
        Artisan::call('migrate');

        Artisan::call('db:seed');
    }


    protected function showValidationMessages( BaseModel $model )
    {
        return implode(PHP_EOL, $model->getValidatorMessages()->all());
    }

}
