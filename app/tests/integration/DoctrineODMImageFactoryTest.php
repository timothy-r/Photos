<?php

use Ace\Photos\Doctrine\ODMImageFactory as Factory;
use Ace\Photos\FixtureTrait;

class DoctrineODMImageFactoryTest extends \PHPUnit_Framework_TestCase
{
    use FixtureTrait;

    public function testCanCreateDoctrineODMImage()
    {
        $factory = new Factory;
        $this->assertInstanceOf('Ace\Photos\IImageFactory', $factory);
        $title = 'What a wonderful panorama';
        $this->givenAFile();
        $result = $factory->create($title, $this->file);
        $this->assertInstanceOf('\Ace\Photos\Doctrine\ODMImage', $result);
        $this->assertSame($title, $result->getTitle());
    }
}
