<?php

use Ace\Photos\Image;
use Ace\Photos\PhotoViewer;
use Ace\Photos\AssertTrait;

require_once(__DIR__.'/../../lib/Ace/Photos/AssertTrait.php');

class PhotoViewerTest extends PHPUnit_Framework_TestCase
{
    use AssertTrait;

    public function testMakeAcceptableImage()
    {
        #$image = new Image;
        $this->givenAPhoto();

        #$image->setName('A test photo');
        $view = new Ace\Photos\PhotoViewer;
        $response = $view->makeAcceptable($this->photo);
        
        $this->assertInstanceOf('\Illuminate\Http\Response', $response);
        
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame($this->photo->getHash(), $response->getETag());

        $this->assertLastModified($this->photo, $response);
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
        $image = new Image;
        $image->setName('A test photo');
        $view = new Ace\Photos\PhotoViewer;
        $response = $view->notModified($image);
        
        $this->assertInstanceOf('\Illuminate\Http\Response', $response);
        
        $this->assertSame(304, $response->getStatusCode());
        $this->assertSame($image->getHash(), $response->getETag());

        $this->assertLastModified($image, $response);
    }

    public function testPreconditionFailedReturns412Response()
    {
        $image = new Image;
        $image->setName('A test photo');
        $view = new Ace\Photos\PhotoViewer;
        $response = $view->preconditionFailed($image);
        
        $this->assertInstanceOf('\Illuminate\Http\Response', $response);
        
        $this->assertSame(412, $response->getStatusCode());
        $this->assertSame($image->getHash(), $response->getETag());
        $this->assertLastModified($image, $response);
    }
}
