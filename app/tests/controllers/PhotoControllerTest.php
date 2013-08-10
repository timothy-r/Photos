<?php
use Ace\Photos\Image;

/**
* @group controller
*/
class PhotoApplicationTest extends TestCase
{
    protected $mock_store;
    
    protected $photo;

    public function setUp()
    {
        parent::setUp();
        $this->mock_store = $this->mock(
            'Ace\Photos\IImageStore',
            array('all', 'add', 'get', 'remove')
        );
    }

    protected function givenAPhoto($id = 1)
    {
        $this->photo = $this->getMock('Ace\Photos\Image', ['getId']);
        $this->photo->expects($this->any())
            ->method('getId')
            ->will($this->returnValue($id));
    }

	/**
	 * Test listing photos works
	 */
	public function testCanListPhotosAsHTML()
	{
        $id = 1;
        $name = 'A fantastic panorama';
        $this->givenAPhoto($id);
        $this->photo->setName($name);
        $photos = [$id => $this->photo];
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
        $id = 1;
        $this->givenAPhoto($id);
        $photos = [$id => $this->photo];
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
        $id = 1;
        $this->givenAPhoto($id);
        $photos = ['1' => $this->photo];
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
        $id = 1;
        $this->givenAPhoto($id);
        $this->mock_store->expects($this->once())
            ->method('get')
            ->with($id)
            ->will($this->returnValue($this->photo));
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
        $id = 1;
        $this->givenAPhoto($id);

        $this->mock_store->expects($this->any())
            ->method('get')
            ->with($id)
            ->will($this->returnValue($this->photo));

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
        $id =1;
        $this->givenAPhoto($id);

        $this->mock_store->expects($this->any())
            ->method('get')
            ->with($id)
            ->will($this->returnValue($this->photo));

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
