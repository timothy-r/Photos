<?php
use Ace\Photos\Image;

class ImageTest extends \PHPUnit_Framework_TestCase
{

    public function testSetName()
    {
        $name = 'Freddy';
        $image = new Image;
        $image->setName($name);
        $this->assertSame($name, $image->getName());
    }

    public function testNameIsEmptyByDefault()
    {
        $image = new Image;
        $this->assertSame('', $image->getName());
    }

    public function testGetHashChangesWhenNameChanges()
    {
        $image = new Image;
        $image->setName('One');
        $hash_1 = $hash = $image->getHash();
        $image->setName('Two');
        $hash_2 = $hash = $image->getHash();
        $this->assertTrue($hash_1 != $hash_2);
    }

    public function testGetId()
    {
        $image = new Image;
        $id = $image->getId();
    }

    public function testCanSetId()
    {
        $image = new Image;
        $id = '401af4';
        $image->setId($id);
        $actual_id = $image->getId();
        $this->assertSame($id, $actual_id);
    }

    public function testCannotOverwriteId()
    {
        $image = new Image;
        $id = '401af4';
        $image->setId($id);
        $image->setId('bogus');
        $actual_id = $image->getId();
        $this->assertSame($id, $actual_id);
    }

    public function testLastModifiedChangesWhenNameSet()
    {
        $image = new Image;
        $modified_1 = $image->getLastModified();
        $image->setName('One');
        $modified_2 = $image->getLastModified();
        $this->assertTrue($modified_1 != $modified_2);
    }
}
