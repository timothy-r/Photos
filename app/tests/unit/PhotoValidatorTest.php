<?php
use Ace\Photos\PhotoValidator;

class PhotoValidatorTest extends \PHPUnit_Framework_TestCase
{
    protected $validator;

    protected $mock_store;

    public function setUp()
    {
        $this->mock_store = $this->getMock(
            '\Ace\Photos\IImageStore', 
            array('get', 'add', 'all')
        );
        $this->validator = new PhotoValidator($this->mock_store);
    }

    /**
    * @dataProvider getInvalidData
    */
    public function testNameMustExistToBeValid($name)
    {
        $result = $this->validator->validate($name);
        $this->assertFalse($result, "Expected '$name' to be invalid");
    }

    public function getInvalidData()
    {
        return array(
            array('name' => ''),
            array('name' => null),
        );
    }

    public function testNamePassesValidation()
    {
        $name = 'A photo of my holidays';
        $result = $this->validator->validate($name);
        $this->assertTrue($result, "Expected '$name' to be valid");
    }

    public function testPhotoMustExistToBeValid()
    {
        $this->mock_store->expects($this->any())
            ->method('get')
            ->will($this->returnValue(null));
        $id = 0;
        $result = $this->validator->validateExists($id);
        $this->assertFalse($result, "Expected validateExists() to return false for missing Photo");
    }
}
