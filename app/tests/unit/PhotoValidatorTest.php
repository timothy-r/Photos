<?php
use Ace\Photos\PhotoValidator;

class PhotoValidatorTest extends \PHPUnit_Framework_TestCase
{
    protected $validator;

    public function setUp()
    {
        $this->validator = new PhotoValidator;
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
        $name = 'A photo of my holoidays';
        $result = $this->validator->validate($name);
        $this->assertTrue($result, "Expected '$name' to be valid");
    }
}
