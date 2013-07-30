<?php
use Ace\Photos\ImageStore;
use Ace\Photos\Image;

class ImageStoreTest extends \PHPUnit_Framework_TestCase
{

    protected $image_store;

    public function setUp()
    {
        $this->image_store = new ImageStore;
    }

    public function testCanAddAnImage()
    {
        $image = new Image;
        $result = $this->image_store->add($image);
        $this->assertSame(true, $result);
    }

    public function testCanListImages()
    {
        $images = $this->image_store->all();
        $this->assertTrue(is_array($images));
    }

    public function testCanGetImage()
    {
        $image = $this->image_store->get();
        #$this->assertTrue(is_array($images));
    }
}
