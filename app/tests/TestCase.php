<?php
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{

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

    public function __call($method, $args)
    {
        if (in_array($method, array('get', 'post', 'put', 'head', 'delete'))){
            return $this->call($method, $args[0]);
        }
        throw new BadMethodCallException("'$method' not supported");

    }

}
