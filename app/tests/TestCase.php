<?php
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
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
            // push the method onto the argument array and call call()
            array_unshift($args, $method);
            return call_user_func_array([$this, 'call'], $args);
        };
        throw new BadMethodCallException("'$method' not supported");
    }
    
    /**
    * test that the Content-Type header in $response is $type
    */
    public function assertContentType($response, $type)
    {
        $this->assertSame($type, $response->headers->get('Content-Type'));
    }

    public function assertETag($response, $tag)
    {
        $this->assertSame($tag, $response->headers->get('ETag'));
    }

    public function assertLastModified($response, $date)
    {
        $this->assertSame($date, $response->headers->get('LastModified'));
    }
}
