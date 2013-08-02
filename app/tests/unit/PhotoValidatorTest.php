<?php
use Ace\Photos\PhotoValidator;

class PhotoValidatorTest extends \PHPUnit_Framework_TestCase
{
    protected $validator;

    public function setUp()
    {
        $mock_store = $this->getMock(
            '\Ace\Photos\IImageStore', 
            array('get', 'add', 'all')
        );
        $this->validator = new PhotoValidator($mock_store);
    }

    /**
    * @dataProvider getInvalidData
    */
    public function testNameMustExist($name)
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
}
