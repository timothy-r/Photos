<?php
use Ace\Photos\Image;

class PhotoApplicationTest extends TestCase {

    protected $mock_store;

    public function setUp()
    {
        parent::setUp();
        $this->mock_store = $this->mock(
            'Ace\Photos\IImageStore',
            array('all', 'add', 'get')
        );
    }

	/**
	 * Test listing photos works
	 */
	public function testCanListPhotos()
	{
        $photos = array('1' => new Image);
        $this->mock_store->expects($this->any())
            ->method('all')
            ->will($this->returnValue($photos));

		$response = $this->get('/photos');
       
		$this->assertTrue($response->isOk());
        $this->assertViewHas('photos');

        $data = $response->original->getData();
        $actual_photos = $data['photos'];
        $this->assertInstanceOf('Ace\Photos\Image', current($actual_photos));
	}

	public function testCanCreatePhoto()
	{
		$crawler = $this->client->request('GET', '/photos/create');

		$this->assertTrue($this->client->getResponse()->isOk());
	}

	public function testCanStorePhotoWithValidData()
	{
        $this->mock_store->expects($this->once())
            ->method('add');
        
        $data = array('name' => 'Test photo');
		$crawler = $this->client->request('POST', '/photos', $data);

        $this->assertResponseStatus(302);
        $this->assertRedirectedToAction('PhotoController@index');
	}

	public function testCanViewPhoto()
    {

    }

    protected function mock($class, $methods)
    {
        $mock = $this->getMock($class, $methods);
        $this->app->instance($class, $mock);
        return $mock;
    }
}
