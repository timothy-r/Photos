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
        $mock_request = $this->mock(
            'Illuminate\Http\Request',
            ['header']
        );
        $mock_request->expects($this->any())
            ->method('header')
            ->will($this->returnValue($accept_type));

        $this->givenAPhoto();

        $view = new Ace\Photos\PhotoViewer;
        $response = $view->makeAcceptable($this->photo);
        
        $this->assertInstanceOf('\Illuminate\Http\Response', $response);
        
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame($this->photo->getHash(), $response->getETag());
        $this->assertLastModified($this->photo, $response);
        $this->assertContentType($content_type, $response);
    }

    public function getAcceptableHeaders()
    {
        return [
            ['text/html', 'text/html'],
        ];
    }

    public function testNotFoundReturns404Response()
    {
        $view = new PhotoViewer;
        $response = $view->notFound(1);
        $this->assertInstanceOf('\Illuminate\Http\Response', $response);
        $this->assertSame(404, $response->getStatusCode());
    }

    public function testNotModifiedReturns304Response()
    {
        $this->givenAPhoto();
        $view = new Ace\Photos\PhotoViewer;
        $response = $view->notModified($this->photo);
        
        $this->assertInstanceOf('\Illuminate\Http\Response', $response);
        
        $this->assertSame(304, $response->getStatusCode());
        $this->assertSame($this->photo->getHash(), $response->getETag());

        $this->assertSame(null, $response->headers->get('Last-Modified'));

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
