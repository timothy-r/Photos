<?php namespace Ace\Photos;

use Ace\Photos\IImage;
use Illuminate\Http\Response;
use DateTime;

trait AssertTrait
{
    protected $photo;

    protected function assertLastModified(IImage $image, $response)
    {
        $last_modified = new DateTime('GMT');
        $last_modified->setTimestamp($image->getLastModified());
        $this->assertEquals($last_modified, $response->getLastModified());
    }

    protected function assertETag(IImage $image, $response)
    {
        $this->assertSame($image->getHash(), $response->getETag());
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
    * test that the Content-Type header in $response is $type
    */
    protected function assertContentType($type, $response)
    {
        $this->assertSame($type, $response->headers->get('Content-Type'));
    }

    protected function mock($class, $methods)
    {
        $mock = $this->getMock($class, $methods);
        \App::instance($class, $mock);
        return $mock;
    }
}
