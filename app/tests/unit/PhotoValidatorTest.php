<?php
use Ace\Photos\PhotoValidator;

class PhotoValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testNameMustExist()
    {
        $name = null;
        $validator = new PhotoValidator;
        $result = $validator->validate($name);
        $this->assertFalse($result, "Expected '$name' to be invalid");
    }

    public function testNamePassesValidation()
    {
        $name = 'A photo of my holoidays';
        $validator = new PhotoValidator;
        $result = $validator->validate($name);
        $this->assertTrue($result, "Expected '$name' to be valid");

    }
}
