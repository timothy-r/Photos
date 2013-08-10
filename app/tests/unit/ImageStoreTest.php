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

    public function tearDown()
    {
        foreach($this->image_store->all() as $image) {
            $this->image_store->remove($image);
        }
    }

    public function testCanAddAnImage()
    {
        $image = new Image;
        $result = $this->image_store->add($image);
        $this->assertSame(true, $result);
        // assert id is set
    }

    public function testCanListImages()
    {
        $image = new Image;
        $this->image_store->add($image);
        $images = $this->image_store->all();
        $this->assertTrue(is_array($images));
        $this->assertTrue(0 < count($images));
    }

    public function testCanGetImage()
    {
        $image = $this->image_store->get(1);
    }

    public function testCanDeleteImage()
    {
        $image = new Image;
        $this->image_store->add($image);
        $result = $this->image_store->remove($image);
        $this->assertSame(true, $result);

    }
}
