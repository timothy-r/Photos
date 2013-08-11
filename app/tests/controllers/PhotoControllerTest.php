<?php
use Ace\Photos\Image;
use Ace\Photos\MongoDbImageStore;

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

    public function tearDown()
    {
        $image_store = new MongoDbImageStore;
        foreach($image_store->all() as $image) {
            $image_store->remove($image);
        }
    }


    protected function givenAPhoto($id = 1)
    {
        $this->photo = $this->getMock('Ace\Photos\Image', ['getId', 'getHash', 'getLastModified']);
        $this->photo->expects($this->any())
            ->method('getId')
            ->will($this->returnValue($id));
        $this->photo->expects($this->any())
            ->method('getHash')
            ->will($this->returnValue('52063fab1e'));
        $this->photo->expects($this->any())
            ->method('getLastModified')
            ->will($this->returnValue(time()));
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
        $mock_factory = $this->mock(
            'Ace\Photos\IImageFactory',
            array('create')
        );
        $id = 1;
        $this->givenAPhoto($id);
        $this->mock_store->expects($this->once())
            ->method('add');
        $mock_factory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($this->photo));

        $data = array('name' => 'Test photo');
		$crawler = $this->client->request('POST', '/photos', $data);

        $this->assertResponseStatus(302);
        $this->assertRedirectedToAction('PhotoController@show', [$id]);
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
        // assert ETag is set
        $this->assertETag($response, $this->photo->getHash());
        $last_modified = date('D, d M Y H:i:s', $this->photo->getLastModified()) . ' GMT';
        $this->assertLastModified($response, $last_modified);
    }

	/**
	 * Test viewing photos works with json
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
        $this->assertETag($response, $this->photo->getHash());
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

    public function testCanRemoveExistingPhoto()
    {
        $id = 1;
        $this->givenAPhoto($id);
        $this->mock_store->expects($this->once())
            ->method('get')
            ->with($id)
            ->will($this->returnValue($this->photo));
        $this->mock_store->expects($this->once())
            ->method('remove')
            ->with($this->photo)
            ->will($this->returnValue(true));
		$crawler = $this->client->request('DELETE', '/photos/' . $id);

        $response = $this->client->getResponse();
        // assert redirected to index page
        $this->assertResponseStatus(302);
        $this->assertRedirectedToAction('PhotoController@index');
    }

    public function testCantRemoveMissingPhoto()
    {
        $id = 1;
        $this->mock_store->expects($this->once())
            ->method('get')
            ->with($id)
            ->will($this->returnValue(null));
        $this->mock_store->expects($this->never())
            ->method('remove');
		$crawler = $this->client->request('DELETE', '/photos/' . $id);

        $response = $this->client->getResponse();
        // assert redirected to index page
        $this->assertResponseStatus(302);
        $this->assertRedirectedToAction('PhotoController@index');
    }

    public function testFailureToRemovePhotoShowsIt()
    {
        $id = 1;
        $this->givenAPhoto($id);
        $this->mock_store->expects($this->once())
            ->method('get')
            ->with($id)
            ->will($this->returnValue($this->photo));
        $this->mock_store->expects($this->once())
            ->method('remove')
            ->with($this->photo)
            ->will($this->returnValue(false));
		$crawler = $this->client->request('DELETE', '/photos/' . $id);

        $response = $this->client->getResponse();
        // assert redirected to index page
        $this->assertResponseStatus(302);
        $this->assertRedirectedToAction('PhotoController@show', [$id]);
    }

    protected function mock($class, $methods)
    {
        $mock = $this->getMock($class, $methods);
        $this->app->instance($class, $mock);
        return $mock;
    }
}
