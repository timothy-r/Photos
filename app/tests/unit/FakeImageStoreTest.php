<?php
use Ace\Photos\FakeImageStore;
use Ace\Photos\Image;

/**
* @group unit
*/
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

    public function getImageIds()
    {
        return array(
            array(1),
            array(5)
        );
    }
    
    /**
    * @dataProvider getImageIds
    */
    public function testCanGetAnImage($id)
    {
        $image = $this->image_store->get($id);
        $this->assertInstanceOf('Ace\Photos\Image', $image);
    }

    public function getInvalidImageIds()
    {
        return array(
            array(0),
            array(null)
        );
    }
    
    /**
    * @dataProvider getInvalidImageIds
    */
    public function testCantGetAMissingImage($id)
    {
        $image = $this->image_store->get($id);
        $this->assertSame(null, $image);
    }
}
