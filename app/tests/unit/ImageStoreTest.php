<?php
use Ace\Photos\ImageStore;
use Ace\Photos\Image;

class ImageStoreTest extends \PHPUnit_Framework_TestCase
{

    public function testCanAddAnImage()
    {
        $image = new Image;
        $image_store = new ImageStore;
        $result = $image_store->add($image);
        $this->assertSame(true, $result);
    }

    public function testCanListImages()
    {
        $image_store = new ImageStore;
        $images = $image_store->all();
        $this->assertTrue(is_array($images));
    }
}
