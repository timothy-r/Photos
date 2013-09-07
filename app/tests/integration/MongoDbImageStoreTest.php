<?php
use Ace\Photos\MongoDbImageStore;
use Ace\Photos\Image;
use Ace\Photos\MockTrait;

/**
* @group integration
*/
class MongoDbImageStoreTest extends \PHPUnit_Framework_TestCase
{
    use MockTrait;

    protected $image_store;

    public function setUp()
    {
        $this->image_store = new MongoDbImageStore;
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
        $this->assertTrue(!is_null($image->getId()));
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
        $image = new Image;
        $this->image_store->add($image);
        $result = $this->image_store->get($image->getId());
        $this->assertInstanceOf('Ace\Photos\Image', $image);
    }

    public function testCanUpdateImage()
    {
        $new_name = 'A new name';
        $image = new Image;
        $this->image_store->add($image);
        $id = $image->getId();

        $image->setName($new_name);
        $result = $this->image_store->update($image);
        $this->assertTrue($result, 'Expected ImageStore::update() to return true');
        $this->assertSame($new_name, $image->getName());

        $result = $this->image_store->get($id);
        $this->assertInstanceOf('Ace\Photos\Image', $result, "Expected ImageStore::get() to return an Image");
        $this->assertEquals($id, $result->getId());
        $this->assertSame($new_name, $result->getName());
    }

    public function testFailureToUpdateImageReturnsFalse()
    {
        $this->givenAMockImage(1);
        $this->mock_image->expects($this->any())
            ->method('save')
            ->will($this->returnValue(['err' => 'an error']));

        $result = $this->image_store->update($this->mock_image);
        $this->assertFalse($result, 'Expected ImageStore to return false for update');
    }

    public function testCanRemoveImage()
    {
        $image = new Image;
        $this->image_store->add($image);
        $id = $image->getId();
        $result = $this->image_store->remove($image);
        $this->assertSame(true, $result);

        $result = $this->image_store->get($id);
        $this->assertTrue(is_null($result));
    }
}
