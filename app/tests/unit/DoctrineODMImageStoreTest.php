<?php

use Ace\Photos\DoctrineODMImageStore;
use Ace\Photos\DoctrineODMImage as Image;
use Ace\Photos\MockTrait;

use Doctrine\ODM\MongoDB\MongoDBException;

/**
* @group unit
*/
class DoctrineODMImageStoreTest extends \PHPUnit_Framework_TestCase
{
    use MockTrait;

    protected $image_store;

    protected $mock_dm;

    protected $mock_repo;

    protected $mock_query_builder;

    protected $mock_query;

    protected $mock_cursor;

    public function setUp()
    {
        $this->mock_dm = $this->getMock('MockDocumentManager', ['persist', 'getRepository', 'createQueryBuilder', 'remove', 'flush']);
        $this->mock_repo = $this->getMock('MockRespository', ['findOneBy']);
        
        $this->mock_query_builder = $this->getMock('MockQueryBuilder', ['getQuery']);

        $this->mock_dm->expects($this->any())
            ->method('createQueryBuilder')
            ->will($this->returnValue($this->mock_query_builder));
        $this->mock_dm->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($this->mock_repo));
        
        
        $this->mock_query = $this->getMock('MockQuery', ['execute']);
        $this->mock_query_builder->expects($this->any())
            ->method('getQuery')
            ->will($this->returnValue($this->mock_query));
       
        $this->mock_cursor = $this->getMock('MockCursor', ['toArray']);

        $this->mock_query->expects($this->any())
            ->method('execute')
            ->will($this->returnValue($this->mock_cursor));

        $mock_config = $this->getMock('Ace\Photos\IDoctrineODMConfig', ['getDocumentManager']);
        $mock_config->expects($this->any())
            ->method('getDocumentManager')
            ->will($this->returnValue($this->mock_dm));

        $this->image_store = new DoctrineODMImageStore($mock_config);
    }

    public function testDocumentManagerIsFlushed()
    {
        $this->mock_dm->expects($this->once())
            ->method('flush');
        $this->image_store->__destruct();
    }

    public function testCanAddAnImage()
    {
        $image = new Image;
        $this->mock_dm->expects($this->once())
            ->method('persist')
            ->with($image);
        $result = $this->image_store->add($image);
        $this->assertTrue($result);
    }

    public function testAddImageReturnsFalseOnFailure()
    {
        $image = new Image;
        $this->mock_dm->expects($this->once())
            ->method('persist')
            ->will($this->throwException(new MongoDBException));
        $result = $this->image_store->add($image);
        $this->assertFalse($result);
    }

    public function testCanListImages()
    {
        $this->mock_cursor->expects($this->any())
            ->method('toArray')
            ->will($this->returnValue([new Image]));
        $images = $this->image_store->all();
        $this->assertTrue(is_array($images));
        $this->assertTrue(0 < count($images));
    }

    public function testCanGetImage()
    {
        $image = new Image;
        $this->mock_repo->expects($this->once())
            ->method('findOneBy')
            ->with(['slug' => 'abcdef'])
            ->will($this->returnValue($image));
        $result = $this->image_store->get('abcdef');
        $this->assertSame($image, $result);
    }

    public function testCanUpdateImage()
    {
        $image = new Image;
        $this->mock_dm->expects($this->once())
            ->method('persist')
            ->with($image);
        $result = $this->image_store->update($image);
    }

    public function testUpdateImageReturnsFalseOnFailure()
    {
        $image = new Image;
        $this->mock_dm->expects($this->once())
            ->method('persist')
            ->will($this->throwException(new MongoDBException));
        $result = $this->image_store->update($image);
        $this->assertFalse($result);
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
