<?php

use Ace\Photos\DoctrineODMImage as Image;

class DoctrineODMImageTest extends PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $image = new Image;
    }

    public function testCanSetName()
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

    public function testHashChangesWhenNameChanges()
    {
        $image = new Image;
        $image->setName('One');
        $hash_1 = $hash = $image->getHash();
        $image->setName('Two');
        $hash_2 = $hash = $image->getHash();
        $this->assertTrue($hash_1 != $hash_2);
    }

    public function testHashIsEmptyByDefault()
    {
        $image = new Image;
        $this->assertSame('', $image->getHash());
    }

    public function testLastModifiedChangesWhenNameSet()
    {
        $image = new Image;
        $modified_1 = $image->getLastModified();
        $image->setName('One');
        $modified_2 = $image->getLastModified();
        $this->assertTrue($modified_1 != $modified_2);
    }

    public function testSizeIsZeroByDefault()
    {
        $image = new Image;
        $this->assertSame(0, $image->getSize());
    }

    public function testLastModifiedIsNullByDefault()
    {
        $image = new Image;
        $this->assertSame(null, $image->getLastModified());
    }
}