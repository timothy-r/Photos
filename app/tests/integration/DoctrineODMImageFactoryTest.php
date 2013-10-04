<?php

use Ace\Photos\DoctrineODMImageFactory as Factory;

class DoctrineODMImageFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateDoctrineODMImage()
    {
        $factory = new Factory;
        $this->assertInstanceOf('Ace\Photos\IImageFactory', $factory);
        $name = 'What a wonderful panorama';
        $result = $factory->create($name);
        $this->assertInstanceOf('\Ace\Photos\DoctrineODMImage', $result);
        $this->assertSame($name, $result->getName());
    }
}
