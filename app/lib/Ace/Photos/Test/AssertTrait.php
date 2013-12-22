<?php namespace Ace\Photos\Test;

use Ace\Photos\IImage;
use Illuminate\Http\Response;
use DateTime;

/**
* @todo rename this trait to reflect its functionality
*/
trait AssertTrait
{
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

    /**
    * test that the Content-Type header in $response is $type
    */
    protected function assertContentType($type, $response)
    {
        $this->assertSame($type, $response->headers->get('Content-Type'));
    }
}
