<?php

use Ace\Photos\Image;
use Ace\Photos\PhotoViewer;

class PhotoViewerTest extends PHPUnit_Framework_TestCase
{
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

        $last_modified = new DateTime('GMT');
        $last_modified->setTimestamp($image->getLastModified());
        $this->assertEquals($last_modified, $response->getLastModified());
    }
}
