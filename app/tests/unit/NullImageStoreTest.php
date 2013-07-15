<?php
use Ace\Photos\NullImageStore;
use Ace\Photos\Image;

class NullImageStoreTest extends \PHPUnit_Framework_TestCase
{

    public function testCanAddAnImage()
    {
        $image = new Image;
        $image_store = new NullImageStore;
        $result = $image_store->add($image);
        $this->assertSame(true, $result);
    }

    public function testCanListImages()
    {
        $image_store = new NullImageStore;
        $images = $image_store->all();
        $this->assertTrue(is_array($images));
    }
}
