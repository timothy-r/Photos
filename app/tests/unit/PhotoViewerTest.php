<?php

use Ace\Photos\Image;
use Ace\Photos\PhotoViewer;
use Ace\Photos\AssertTrait;

require_once(__DIR__.'/../../lib/Ace/Photos/AssertTrait.php');

class PhotoViewerTest extends PHPUnit_Framework_TestCase
{
    use AssertTrait;

    /**
    * @dataProvider getAcceptableHeaders
    */
    public function testMakeAcceptableImage($accept_type, $content_type)
    {
        $mock_viewer = $this->getMock('Ace\Photos\PhotoViewer', ['getAcceptableContentType']);
        $mock_viewer->expects($this->any())
            ->method('getAcceptableContentType')
            ->will($this->returnValue($accept_type));

        $this->givenAPhoto();

        $response = $mock_viewer->makeAcceptable($this->photo);
        
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame($this->photo->getHash(), $response->getETag());
        $this->assertLastModified($this->photo, $response);
        $this->assertContentType($content_type, $response);
    }

    public function testMakeUnacceptableImage()
    {
        $mock_viewer = $this->getMock('Ace\Photos\PhotoViewer', ['getAcceptableContentType']);
        $mock_viewer->expects($this->any())
            ->method('getAcceptableContentType')
            ->will($this->returnValue('application/xhtml+xml'));

        $this->givenAPhoto();

        $response = $mock_viewer->makeAcceptable($this->photo);
        
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
        $view = new PhotoViewer;
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
        $this->givenAPhoto();
        $view = new Ace\Photos\PhotoViewer;
        $response = $view->notModified($this->photo);
        
        $this->assertInstanceOf('\Illuminate\Http\Response', $response);
        
        $this->assertSame(304, $response->getStatusCode());
        $this->assertSame($this->photo->getHash(), $response->getETag());

        $this->assertSame(null, $response->headers->get('Last-Modified'));
        $this->assertTrue($response->headers->has('Date'));

        $this->assertContentType(null, $response);
    }

    public function testPreconditionFailedReturns412Response()
    {
        $this->givenAPhoto();
        $view = new Ace\Photos\PhotoViewer;
        $response = $view->preconditionFailed($this->photo);
        
        $this->assertInstanceOf('\Illuminate\Http\Response', $response);
        
        $this->assertSame(412, $response->getStatusCode());
        $this->assertSame($this->photo->getHash(), $response->getETag());
        $this->assertLastModified($this->photo, $response);
    }
}
