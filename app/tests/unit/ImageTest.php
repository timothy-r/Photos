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

    public function testGetHash()
    {
        $image = new Image;
        $hash = $image->getHash();
    }

    public function testGetId()
    {
        $image = new Image;
        $id = $image->getId();
    }
}
