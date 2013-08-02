<?php
use Ace\Photos\FakeImageStore;
use Ace\Photos\Image;

class FakeImageStoreTest extends \PHPUnit_Framework_TestCase
{
    protected $image_store;

    public function setUp()
    {
        $this->image_store = new FakeImageStore;
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
        foreach ($images as $image) {
            $this->assertInstanceOf('Ace\Photos\Image', $image);
        }
    }

    public function testCanGetAnImage()
    {
        $id = 1;
        $image = $this->image_store->get($id);
        $this->assertInstanceOf('Ace\Photos\Image', $image);
        $this->assertSame($id, $image->getId());
    }
}
