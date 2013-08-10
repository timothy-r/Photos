<?php
use Ace\Photos\MongoDbImageFactory as Factory;

class MongoDbImageFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateMongoDbImage()
    {
        $factory = new Factory;
        $this->assertInstanceOf('Ace\Photos\IImageFactory', $factory);
        $name = 'What a wonderful panorama';
        $result = $factory->create($name);
        $this->assertInstanceOf('\Ace\Photos\Image', $result);
        $this->assertSame($name, $result->getName());
    }
}
