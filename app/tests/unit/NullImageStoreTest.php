<?php
use Ace\Photos\NullImageStore;
use Ace\Photos\Image;

/**
* @group unit
*/
class NullImageStoreTest extends \PHPUnit_Framework_TestCase
{
    protected $image_store;

    public function setUp()
    {
        $this->image_store = new NullImageStore;
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

    public function testCanGetAnImage()
    {
        $id = 1;
        $image = $this->image_store->get($id);
        $this->assertNull($image);
    }
}
