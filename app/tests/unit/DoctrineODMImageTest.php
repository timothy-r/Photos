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

    public function testCanSetFile()
    {
        $image = new Image;
        $filename = "dir/path/image.png";
        $local_file = "/tmp/uploads/thing.png";

        $image->setFile($filename, $local_file);

    }

    public function testLastModifiedChangesWhenFilenameSet()
    {
        $local_file = "/tmp/uploads/thing.png";
        $image = new Image;
        $modified_1 = $image->getLastModified();
        $image->setFile('all-images/one.png', $local_file);
        $modified_2 = $image->getLastModified();

        $this->assertTrue($modified_1 != $modified_2);
    }

    public function testHashChangesWhenFileSet()
    {
        $local_file = "/tmp/uploads/thing.png";
        $image = new Image;
        $image->setFile('all-images/one.png', $local_file);
        $hash_1 = $image->getHash();
        $image->setFile('all-images/two.png', $local_file);
        $hash_2 = $image->getHash();

        $this->assertTrue($hash_1 != $hash_2);
    }
}
