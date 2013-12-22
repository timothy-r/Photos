<?php

use Ace\Photos\Image;
use Ace\Photos\ImageView;
use Ace\Photos\Test\AssertTrait;
use Ace\Photos\Test\MockTrait;

class ImageViewTest extends PHPUnit_Framework_TestCase
{
    use AssertTrait;
    
    use MockTrait;

    /**
    * @dataProvider getAcceptableHeaders
    */
    public function testMakeAcceptable($accept_type, $content_type)
    {
        $mock_viewer = $this->getMock('Ace\Photos\ImageView', ['getAcceptableContentType']);
        $mock_viewer->expects($this->any())
            ->method('getAcceptableContentType')
            ->will($this->returnValue($accept_type));

        $this->givenAMockImage();

        $response = $mock_viewer->makeAcceptable($this->mock_image);
        
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame($this->mock_image->getHash(), $response->getETag());
        $this->assertTrue(0 < $response->headers->get('Content-Length'));
        $this->assertLastModified($this->mock_image, $response);
        $this->assertContentType($content_type, $response);
    }

    /**
    * @dataProvider getAcceptableHeaders
    */
    public function testMakeManyAcceptable($accept_type, $content_type)
    {
        $mock_viewer = $this->getMock('Ace\Photos\ImageView', ['getAcceptableContentType']);
        $mock_viewer->expects($this->any())
            ->method('getAcceptableContentType')
            ->will($this->returnValue($accept_type));

        $this->givenAMockImage();

        $response = $mock_viewer->makeManyAcceptable([$this->mock_image]);
        
        $this->assertSame(200, $response->getStatusCode());
        $this->assertContentType($content_type, $response);
        $this->assertTrue(0 < $response->headers->get('Content-Length'));
    }

    public function testMakeUnacceptableImage()
    {
        $mock_viewer = $this->getMock('Ace\Photos\ImageView', ['getAcceptableContentType']);
        $mock_viewer->expects($this->any())
            ->method('getAcceptableContentType')
            ->will($this->returnValue('application/xhtml+xml'));

        $this->givenAMockImage();

        $response = $mock_viewer->makeAcceptable($this->mock_image);
        
        $this->assertSame(406, $response->getStatusCode());
    }

    public function testMakeManyUnacceptable()
    {
        $mock_viewer = $this->getMock('Ace\Photos\ImageView', ['getAcceptableContentType']);
        $mock_viewer->expects($this->any())
            ->method('getAcceptableContentType')
            ->will($this->returnValue('application/xhtml+xml'));

        $this->givenAMockImage();

        $response = $mock_viewer->makeManyAcceptable([$this->mock_image]);
        
        $this->assertSame(406, $response->getStatusCode());
    }

    public function getAcceptableHeaders()
    {
        return [
            ['text/html', 'text/html'],
            ['application/json', 'application/json'],
        ];
    }

    public function testNotFoundReturns404Response()
    {
        $view = new ImageView;
        $response = $view->notFound(1);
        $this->assertInstanceOf('\Illuminate\Http\Response', $response);
        $this->assertSame(404, $response->getStatusCode());
    }

    /**
    * 
    * 304 response 
    * MUST contain a Date header
    * MUST contain an ETag header
    * MUST NOT contain a Last-Modified header
    * MUST NOT contain a Content-Type header
    */
    public function testNotModifiedReturns304Response()
    {
        $this->givenAMockImage();
        $view = new Ace\Photos\ImageView;
        $response = $view->notModified($this->mock_image);
        
        $this->assertInstanceOf('\Illuminate\Http\Response', $response);
        
        $this->assertSame(304, $response->getStatusCode());

        $this->assertTrue($response->headers->has('Date'));
        $this->assertSame($this->mock_image->getHash(), $response->getETag());

        $this->assertSame(null, $response->headers->get('Last-Modified'));
        $this->assertContentType(null, $response);
    }

    public function testPreconditionFailedReturns412Response()
    {
        $this->givenAMockImage();
        $view = new Ace\Photos\ImageView;
        $response = $view->preconditionFailed($this->mock_image);
        
        $this->assertInstanceOf('\Illuminate\Http\Response', $response);
        
        $this->assertSame(412, $response->getStatusCode());
        $this->assertSame($this->mock_image->getHash(), $response->getETag());
        $this->assertLastModified($this->mock_image, $response);
    }
}
