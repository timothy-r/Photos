<?php
use Ace\Photos\FakeImageStore;
use Ace\Photos\Image;

class FakeImageStoreTest extends \PHPUnit_Framework_TestCase
{

    public function testCanAddAnImage()
    {
        $image = new Image;
        $image_store = new FakeImageStore;
        $result = $image_store->add($image);
        $this->assertSame(true, $result);
    }

    public function testCanListImages()
    {
        $image_store = new FakeImageStore;
        $images = $image_store->all();
        $this->assertTrue(is_array($images));
        foreach ($images as $image) {
            $this->assertInstanceOf('Ace\Photos\Image', $image);
        }
    }
}
