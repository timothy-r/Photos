<?php

use Ace\Photos\DoctrineODMImageFactory as Factory;

class DoctrineODMImageFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateDoctrineODMImage()
    {
        $factory = new Factory;
        $this->assertInstanceOf('Ace\Photos\IImageFactory', $factory);
        $title = 'What a wonderful panorama';
        $result = $factory->create($title);
        $this->assertInstanceOf('\Ace\Photos\DoctrineODMImage', $result);
        $this->assertSame($title, $result->getTitle());
    }
}
