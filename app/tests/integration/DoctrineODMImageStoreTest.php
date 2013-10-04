<?php

use Ace\Photos\DoctrineODMImageStore;
use Ace\Photos\DoctrineODMImage as Image;
use Ace\Photos\MockTrait;

/**
* @group unit
*/
class DoctrineODMImageStoreTest extends \PHPUnit_Framework_TestCase
{
    use MockTrait;

    protected $image_store;

    protected $mock_dm;

    protected $mock_query_builder;

    protected $mock_query;

    public function setUp()
    {
        $this->mock_dm = $this->getMock('MockDocumentManager', ['persist', 'find', 'createQueryBuilder', 'remove', 'flush']);
        
        $this->mock_query_builder = $this->getMock('MockQueryBuilder', ['getQuery']);
        $this->mock_dm->expects($this->any())
            ->method('createQueryBuilder')
            ->will($this->returnValue($this->mock_query_builder));
        
        $this->mock_query = $this->getMock('MockQuery', ['execute']);
        $this->mock_query_builder->expects($this->any())
            ->method('getQuery')
            ->will($this->returnValue($this->mock_query));
        
        $mock_config = $this->getMock('Ace\Photos\IDoctrineODMConfig', ['getDocumentManager']);
        $mock_config->expects($this->any())
            ->method('getDocumentManager')
            ->will($this->returnValue($this->mock_dm));

        $this->image_store = new DoctrineODMImageStore($mock_config);
    }

    public function testCanAddAnImage()
    {
        $image = new Image;
        $this->mock_dm->expects($this->once())
            ->method('persist')
            ->with($image);
        $result = $this->image_store->add($image);
    }

    public function testCanListImages()
    {
        $this->mock_query->expects($this->any())
            ->method('execute')
            ->will($this->returnValue([new Image]));
        $images = $this->image_store->all();
        $this->assertTrue(is_array($images));
        $this->assertTrue(0 < count($images));
    }

    public function testCanGetImage()
    {
        $image = new Image;
        $this->mock_dm->expects($this->once())
            ->method('find')
            ->with('Image', 'abcdef')
            ->will($this->returnValue($image));
        $result = $this->image_store->get('abcdef');
        $this->assertInstanceOf('Ace\Photos\DoctrineODMImage', $image);
    }

    public function testCanUpdateImage()
    {
        $image = new Image;
        $this->mock_dm->expects($this->once())
            ->method('persist')
            ->with($image);
        $result = $this->image_store->update($image);
    }

    public function testCanRemoveImage()
    {
        $image = new Image;
        $this->mock_dm->expects($this->once())
            ->method('remove')
            ->with($image);
        $result = $this->image_store->remove($image);
    }
}
