<?php
use Ace\Photos\PhotoExistsValidator;

class PhotoExistsValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testExistingPhotoIsValid()
    {
        $id = 99;
        $store = $this->getMock('Ace\Photos\IImageStore', array('add', 'get', 'all'));
        $validator = new PhotoExistsValidator($store);
        $image = $this->getMock('Ace\Photos\Image');
        $store->expects($this->any())
            ->method('get')
            ->with($id)
            ->will($this->returnValue($image));

        $result = $validator->validate($id);
        $this->assertTrue($result, "Expected validate to return true");
    }

    public function testMissingPhotoIsNotValid()
    {
        $id = 99;
        $store = $this->getMock('Ace\Photos\IImageStore', array('add', 'get', 'all'));
        $validator = new PhotoExistsValidator($store);
        $image = $this->getMock('Ace\Photos\Image');
        $store->expects($this->any())
            ->method('get')
            ->with($id)
            ->will($this->returnValue(null));

        $result = $validator->validate($id);
        $this->assertFalse($result, "Expected validate to return false");
    }
}
