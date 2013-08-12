<?php
use Ace\Photos\Image;
use Ace\Photos\MongoDbImageStore;
use Way\Tests\Assert;
use Ace\Photos\AssertTrait;

/**
* @group controller
*/
class PhotoApplicationTest extends TestCase
{
    use AssertTrait;

    protected $mock_store;

    protected $photo;

    public function setUp()
    {
        parent::setUp();
        $this->mock_store = $this->mock(
            'Ace\Photos\IImageStore',
            ['all', 'add', 'get', 'remove', 'update']
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

		$response = $this->get(
            '/photos', 
            [], 
            [], 
            ['HTTP_Accept' => 'application/json']
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

		$response = $this->get(
            '/photos', 
            [], 
            [], 
            ['HTTP_Accept' => 'application/xml']
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
            ['create']
        );
        $id = 1;
        $this->givenAPhoto($id);
        $this->mock_store->expects($this->once())
            ->method('add');
        $mock_factory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($this->photo));

        $data = ['name' => 'Test photo'];
		$response = $this->post('/photos', $data);

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
		$response = $this->get('/photos/' . $id);

		$this->assertTrue($response->isOk());
        $this->assertContentType($response, 'text/html; charset=UTF-8');
        // assert ETag is set
        $this->assertETag($this->photo, $response);
        $this->assertLastModified($this->photo, $response);
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

		$response = $this->get('/photos/'.$id, [], [], ['HTTP_Accept' => 'application/json']);
       
		$this->assertTrue($response->isOk());
        $this->assertContentType($response, 'application/json');
        $data = json_decode($response->getContent());
        $this->assertInstanceOf('StdClass', $data);
        $this->assertETag($this->photo, $response);
	}

	public function testConditionalRequestToViewPhotoGets304IfMatches()
    {
        $id = 1;
        $this->givenAPhoto($id);
        $this->mock_store->expects($this->once())
            ->method('get')
            ->with($id)
            ->will($this->returnValue($this->photo));
        $headers = ['HTTP_If-None-Match' => $this->photo->getHash()];

        $response = $this->get('/photos/' . $id, [], [], $headers);
        $this->assertResponseStatus(304);
        $this->assertContentType($response, 'text/html; charset=UTF-8');

        // assert ETag is set
        $this->assertETag($this->photo, $response);
        // assert Last-Modified is also set
        $this->assertLastModified($this->photo, $response);
    }

	public function testConditionalRequestToViewPhotoGetsNewPhotoIfNotMatches()
    {
        $id = 1;
        $this->givenAPhoto($id);
        $this->mock_store->expects($this->once())
            ->method('get')
            ->with($id)
            ->will($this->returnValue($this->photo));
        $headers = ['HTTP_If-None-Match' => 'not-an-etag'];

        $response = $this->get('/photos/' . $id, [], [], $headers);
		$this->assertTrue($response->isOk());

        // assert ETag is set
        $this->assertETag($this->photo, $response);
        // assert Last-Modified is also set
        $this->assertLastModified($this->photo, $response);
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

		$response = $this->get(
            '/photos/'.$id, 
            [], 
            [], 
            ['HTTP_Accept' => 'application/xml']
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
		$response = $this->get('/photos/' . $id);

        $this->assertResponseStatus(404);
    }

    public function testCanUpdatePhotoWithoutETag()
    {
        $id = 1;
        $this->givenAPhoto($id);
        $this->mock_store->expects($this->once())
            ->method('get')
            ->with($id)
            ->will($this->returnValue($this->photo));
        $this->mock_store->expects($this->once())
            ->method('update')
            ->with($this->photo)
            ->will($this->returnValue(true));
        $data = ['name' => 'A new name'];
		$response = $this->put('/photos/' . $id, $data);

        // assert redirected to view page
        $this->assertResponseStatus(302);
        $this->assertRedirectedToAction('PhotoController@show', [$id]);
    }

    public function testCanUpdatePhotoWithMatchingETag()
    {
        $id = 1;
        $this->givenAPhoto($id);
        $this->mock_store->expects($this->once())
            ->method('get')
            ->with($id)
            ->will($this->returnValue($this->photo));
        $this->mock_store->expects($this->once())
            ->method('update')
            ->with($this->photo)
            ->will($this->returnValue(true));
        $data = ['name' => 'A new name'];
        $headers = ['HTTP_If-Match' => $this->photo->getHash()];
		$response = $this->put('/photos/' . $id, $data, [], $headers);

        // assert redirected to view page
        $this->assertResponseStatus(302);
        $this->assertRedirectedToAction('PhotoController@show', [$id]);
    }

    public function testCantUpdatePhotoWithNonMatchingETag()
    {
        $id = 1;
        $this->givenAPhoto($id);
        $this->mock_store->expects($this->once())
            ->method('get')
            ->with($id)
            ->will($this->returnValue($this->photo));
        $this->mock_store->expects($this->never())
            ->method('update');
        $data = ['name' => 'A new name'];
        $headers = ['HTTP_If-Match' => 'not-an-etag'];
		$response = $this->put('/photos/' . $id, $data, [], $headers);

        // assert Precondition Failed response
        $this->assertResponseStatus(412);
    }

    public function testCantUpdateMissingPhoto()
    {
        $id = 1;
        $this->mock_store->expects($this->once())
            ->method('get')
            ->with($id)
            ->will($this->returnValue(null));
        $this->mock_store->expects($this->never())
            ->method('update');
        $data = ['name' => 'A new name'];
		$response = $this->put('/photos/' . $id, $data);

        // assert redirected to view page
        $this->assertResponseStatus(404);
    }

    public function testCanRemoveExistingPhotoWithoutETag()
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
		$response = $this->delete('/photos/' . $id);

        // assert redirected to index page
        $this->assertResponseStatus(302);
        $this->assertRedirectedToAction('PhotoController@index');
    }

    public function testCanRemoveExistingPhotoWithMatchingETag()
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
        $headers = ['HTTP_If-Match' => $this->photo->getHash()];
		$response = $this->delete('/photos/' . $id, [], [], $headers);

        // assert redirected to index page
        $this->assertResponseStatus(302);
        $this->assertRedirectedToAction('PhotoController@index');
    }

    public function testCantRemoveExistingPhotoWithNonMatchingETag()
    {
        $id = 1;
        $this->givenAPhoto($id);
        $this->mock_store->expects($this->once())
            ->method('get')
            ->with($id)
            ->will($this->returnValue($this->photo));
        $this->mock_store->expects($this->never())
            ->method('remove');

        $headers = ['HTTP_If-Match' => 'not-an-etag'];
		$response = $this->delete('/photos/' . $id, [], [], $headers);

        // assert redirected to view Photo page
        $this->assertResponseStatus(412);
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
		$response = $this->delete('/photos/' . $id);

        // assert redirected to index page
        $this->assertResponseStatus(404);
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
		$response = $this->delete('/photos/' . $id);

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
