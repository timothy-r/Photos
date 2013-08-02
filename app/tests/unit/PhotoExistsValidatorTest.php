<?php
use Ace\Photos\PhotoExistsValidator;

class PhotoExistsValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testExistingPhotoIsValid()
    {
        $store = $this->getMock('Ace\Photos\IImageStore', array('add', 'get', 'all'));
        $validator = new PhotoExistsValidator($store);
    }
}
