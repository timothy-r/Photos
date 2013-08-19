<?php
use Ace\Photos\ImageExistsFilter;
use Ace\Photos\AssertTrait;

class ImageExistsFilterTest extends PHPUnit_Framework_TestCase
{
    use AssertTrait;

    public function testExistingImageIsValid()
    {
        $id = 1;
        $mock_image = $this->getMock('Ace\Photos\Image');
        $mock_store = $this->mock('Ace\Photos\IImageStore',
            ['all', 'add', 'get', 'remove', 'update']
        );
        $mock_store->expects($this->any())
            ->method('get')
            ->will($this->returnValue($mock_image));

        $mock_route = $this->getMock('Illuminate\Routing\Route', ['getParameter'], [], '', false);
        $mock_route->expects($this->any())
            ->method('getParameter')
            ->will($this->returnValue($id));

        $filter = new ImageExistsFilter;
        $result = $filter->filter($mock_route);

        // null is validation suceeded
        $this->assertNull($result);
    }
}
