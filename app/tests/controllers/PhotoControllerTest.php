<?php
use Ace\Photos\Image;

/**
* @group controller
*/
class PhotoApplicationTest extends TestCase
{
    protected $mock_store;

    public function setUp()
    {
        parent::setUp();
        $this->mock_store = $this->mock(
            'Ace\Photos\IImageStore',
            array('all', 'add', 'get', 'remove')
        );
    }

	/**
	 * Test listing photos works
	 */
	public function testCanListPhotosAsHTML()
	{
        $name = 'A fantastic panorama';
        $image = new Image;
        $image->setName($name);
        $photos = array('1' => $image);
        $this->mock_store->expects($this->any())
            ->method('all')
            ->will($this->returnValue($photos));

		$response = $this->get('/photos');
       
		$this->assertTrue($response->isOk());
        $this->assertContentType($response, 'text/html; charset=UTF-8');
        $this->assertViewHas('photos');

        $data = $response->original->getData();
        $photo = current($data['photos']);
        $this->assertSame($name, $photo['name']);
        // test uri property
	}

	/**
	 * Test listing photos works with json
	 */
	public function testCanListPhotosAsJson()
	{
        $photos = array('1' => new Image);
        $this->mock_store->expects($this->any())
            ->method('all')
            ->will($this->returnValue($photos));

		$response = $this->call(
            'get', 
            '/photos', 
            array(), 
            array(), 
            array('HTTP_Accept' => 'application/json')
        );
       
		$this->assertTrue($response->isOk());
        $this->assertContentType($response, 'application/json');
        $data = json_decode($response->getContent());
        $this->assertInstanceOf('StdClass', $data);
	}

	/**
	 */
	public function testCantListPhotosAsXML()
	{
        $photos = array('1' => new Image);
        $this->mock_store->expects($this->any())
            ->method('all')
            ->will($this->returnValue($photos));

		$response = $this->call(
            'get', 
            '/photos', 
            array(), 
            array(), 
            array('HTTP_Accept' => 'application/xml')
        );
       
		$this->assertFalse($response->isOk());
	}

	public function testCanViewCreatePhotoForm()
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

	public function testCanViewPhotoAsHTML()
    {
        $photo = new Image;
        $id = 1;
        $this->mock_store->expects($this->once())
            ->method('get')
            ->with($id)
            ->will($this->returnValue($photo));
		$crawler = $this->client->request('GET', '/photos/' . $id);

        $response = $this->client->getResponse();
		$this->assertTrue($response->isOk());
        $this->assertContentType($response, 'text/html; charset=UTF-8');
    }

	/**
	 * Test listing photos works with json
	 */
	public function testCanViewPhotoAsJson()
	{
        $photo = new Image;
        $id =1;
        $this->mock_store->expects($this->any())
            ->method('get')
            ->with($id)
            ->will($this->returnValue($photo));

		$response = $this->call(
            'get', 
            '/photos/'.$id, 
            array(), 
            array(), 
            array('HTTP_Accept' => 'application/json')
        );
       
		$this->assertTrue($response->isOk());
        $this->assertContentType($response, 'application/json');
        $data = json_decode($response->getContent());
        $this->assertInstanceOf('StdClass', $data);
	}

	/**
	 */
	public function testCantViewPhotoAsXML()
	{
        $photo = new Image;
        $id =1;
        $this->mock_store->expects($this->any())
            ->method('get')
            ->with($id)
            ->will($this->returnValue($photo));

		$response = $this->call(
            'get', 
            '/photos/'.$id, 
            array(), 
            array(), 
            array('HTTP_Accept' => 'application/xml')
        );
       
		$this->assertFalse($response->isOk());
	}


	public function testCantViewMissingPhoto()
    {
        $id = 123;
        $this->mock_store->expects($this->once())
            ->method('get')
            ->with($id)
            ->will($this->returnValue(null));
		$crawler = $this->client->request('GET', '/photos/' . $id);

		$this->assertTrue($this->client->getResponse()->isRedirection());
        $this->assertRedirectedToAction('PhotoController@index');
    }

    protected function mock($class, $methods)
    {
        $mock = $this->getMock($class, $methods);
        $this->app->instance($class, $mock);
        return $mock;
    }
}
