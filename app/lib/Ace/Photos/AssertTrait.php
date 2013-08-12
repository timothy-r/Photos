<?php namespace Ace\Photos;

use Ace\Photos\IImage;
use Illuminate\Http\Response;
use DateTime;

trait AssertTrait
{
    protected function assertLastModified(IImage $image, Response $response)
    {
        $last_modified = new DateTime('GMT');
        $last_modified->setTimestamp($image->getLastModified());
        $this->assertEquals($last_modified, $response->getLastModified());
    }

    protected function assertETag(IImage $image, $response)
    {
        $this->assertSame($image->getHash(), $response->getETag());
    }
}
