<?php

use Ace\Photos\Doctrine\ODMImageStore;
use Way\Tests\Assert;
use Ace\Photos\AssertTrait;
use Ace\Photos\Test\MockTrait;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
* @group controller
*/
class PhotoControllerTest extends TestCase
{
    use AssertTrait;
    
    use MockTrait;

    protected $mock_file;

    public function setUp()
    {
        parent::setUp();
        $this->givenAMockImageStore();
    }

	/**
	 * Test listing photos works
	 */
	public function testCanListPhotosAsHTML()
	{
        $id = 1;
        $title = 'A fantastic panorama';
        $this->givenSomeImagesInTheStore($id, $title);

		$response = $this->get('/photos');
       
		$this->assertTrue($response->isOk());
        $this->assertContentType('text/html; charset=UTF-8', $response);
        $this->assertViewHas('photos');

        $data = $response->original->getData();
        $photo = current($data['photos']);
        $this->assertSame($title, $photo['title']);
        // test uri property
	}

	/**
	 * Test listing photos works with json
	 */
	public function testCanListPhotosAsJson()
	{
        $id = 1;
        $this->givenSomeImagesInTheStore($id);

		$response = $this->get(
            '/photos', 
            [], 
            [], 
            ['HTTP_Accept' => 'application/json']
        );
       
		$this->assertTrue($response->isOk());
        $this->assertContentType('application/json', $response);
        $data = json_decode($response->getContent());
        $this->assertInstanceOf('StdClass', $data);
	}

	/**
	 */
	public function testCantListPhotosAsXML()
	{
        $id = 1;
        $this->givenSomeImagesInTheStore($id);

		$response = $this->get(
            '/photos', 
            [], 
            [], 
            ['HTTP_Accept' => 'application/xml']
        );
       
		$this->assertFalse($response->isOk());
	}

	public function testCantListPhotosWithNoAcceptHeader()
	{
        $id = 1;
        $this->givenSomeImagesInTheStore($id);

		$response = $this->get(
            '/photos', 
            [], 
            [], 
            ['HTTP_Accept' => '']
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
        $this->givenAMockFactory();
        $id = 1;
        $this->givenAMockImage($id);
        $this->mock_image_store->expects($this->once())
            ->method('add')
            ->will($this->returnValue(true));

        $this->mock_factory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($this->mock_image));
        
        $this->givenAMockFile();
        $data = ['title' => 'Test photo'];
        $files = ['file' => $this->mock_file];
        
		$response = $this->post('/photos', $data, $files);

        $this->assertResponseStatus(302);
        $this->assertRedirectedToAction('PhotoController@show', [$id]);
	}

	public function testFailureToStoreImageShowsCreateForm()
	{
        $this->givenAMockFactory();
        $id = 1;
        $this->givenAMockImage($id);
        $this->mock_image_store->expects($this->once())
            ->method('add')
            ->will($this->returnValue(false));

        $this->mock_factory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($this->mock_image));
        
        $this->givenAMockFile();
        $data = ['title' => 'Test photo'];
        $files = ['file' => $this->mock_file]; 
        
		$response = $this->post('/photos', $data, $files);

        $this->assertResponseStatus(302);
        $this->assertRedirectedToAction('PhotoController@create', []);
	}

	public function testCanViewPhotoAsHTML()
    {
        $id = 1;
        $this->givenAnImageInTheStoreWithId($id);

		$response = $this->get('/photos/' . $id);

		$this->assertTrue($response->isOk());
        $this->assertContentType('text/html; charset=UTF-8', $response);
        // assert ETag is set
        $this->assertETag($this->mock_image, $response);
        $this->assertLastModified($this->mock_image, $response);
    }

	/**
	 * Test viewing photos works with json
	 */
	public function testCanViewPhotoAsJson()
	{
        $id = 1;
        $this->givenAnImageInTheStoreWithId($id);

		$response = $this->get('/photos/'.$id, [], [], ['HTTP_Accept' => 'application/json']);
       
		$this->assertTrue($response->isOk());
        $this->assertContentType('application/json', $response);
        $data = json_decode($response->getContent());
        $this->assertInstanceOf('StdClass', $data);
        $this->assertETag($this->mock_image, $response);
	}

	public function testConditionalRequestToViewPhotoGetsNewPhotoIfNotMatches()
    {
        $id = 1;
        $this->givenAnImageInTheStoreWithId($id);

        $headers = ['HTTP_If-None-Match' => 'not-an-etag'];

        $response = $this->get('/photos/' . $id, [], [], $headers);
		$this->assertTrue($response->isOk());

        // assert ETag is set
        $this->assertETag($this->mock_image, $response);
        // assert Last-Modified is also set
        $this->assertLastModified($this->mock_image, $response);
    }

	/**
	 */
	public function testCantViewPhotoAsXML()
	{
        $id =1;
        $this->givenAnImageInTheStoreWithId($id);

		$response = $this->get(
            '/photos/'.$id, 
            [], 
            [], 
            ['HTTP_Accept' => 'application/xml']
        );
       
		$this->assertFalse($response->isOk());
	}

    public function testCanUpdatePhoto()
    {
        $id = 1;
        $this->givenAnImageInTheStoreWithId($id);

        $this->mock_image_store->expects($this->once())
            ->method('update')
            ->with($this->mock_image)
            ->will($this->returnValue(true));
        $data = ['title' => 'A new title'];
		$response = $this->put('/photos/' . $id, $data);

        // assert redirected to view page
        $this->assertResponseStatus(302);
        $this->assertRedirectedToAction('PhotoController@show', [$id]);
    }

    public function testCanRemovePhoto()
    {
        $id = 1;
        $this->givenAnImageInTheStoreWithId($id);

        $this->mock_image_store->expects($this->once())
            ->method('remove')
            ->with($this->mock_image)
            ->will($this->returnValue(true));
		$response = $this->delete('/photos/' . $id);

        // assert redirected to index page
        $this->assertResponseStatus(302);
        $this->assertRedirectedToAction('PhotoController@index');
    }

    public function testFailureToRemovePhotoShowsIt()
    {
        $id = 1;
        $this->givenAnImageInTheStoreWithId($id);

        $this->mock_image_store->expects($this->once())
            ->method('remove')
            ->with($this->mock_image)
            ->will($this->returnValue(false));
		$response = $this->delete('/photos/' . $id);

        // assert redirected to index page
        $this->assertResponseStatus(302);
        $this->assertRedirectedToAction('PhotoController@show', [$id]);
    }

    public function givenAMockFile()
    {
        $path = __DIR__.'/../fixtures/tux.png';
        $this->mock_file = new UploadedFile($path, 'image.png');
    }
    
    protected function givenSomeImagesInTheStore($id, $title = 'Image')
    {
        $this->givenAMockImage($id);
        $this->mock_image->expects($this->any())
            ->method('getTitle')
            ->will($this->returnValue($title));
        
        $photos = [$id => $this->mock_image];
        $this->mock_image_store->expects($this->any())
            ->method('all')
            ->will($this->returnValue($photos));
    }

    protected function givenAnImageInTheStoreWithId($id)
    {
        $this->givenAMockImage($id);
        $this->mock_image_store->expects($this->once())
            ->method('get')
            ->with($id)
            ->will($this->returnValue($this->mock_image));
    }
}
