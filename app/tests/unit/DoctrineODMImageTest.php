<?php

use Ace\Photos\DoctrineODMImage as Image;
use Ace\Photos\FixtureTrait;

class DoctrineODMImageTest extends PHPUnit_Framework_TestCase
{
    use FixtureTrait;

    public function testCreate()
    {
        $image = new Image;
    }

    public function testCanSetTitle()
    {
        $title = 'Freddy';
        $image = new Image;
        $image->setTitle($title);
        $this->assertSame($title, $image->getTitle());
    }

    public function testTitleIsEmptyByDefault()
    {
        $image = new Image;
        $this->assertSame('', $image->getTitle());
    }

    public function testHashChangesWhenTitleChanges()
    {
        $image = new Image;
        $image->setTitle('One');
        $hash_1 = $hash = $image->getHash();
        $image->setTitle('Two');
        $hash_2 = $hash = $image->getHash();
        $this->assertTrue($hash_1 != $hash_2);
    }

    public function testHashIsEmptyByDefault()
    {
        $image = new Image;
        $this->assertSame('', $image->getHash());
    }

    public function testLastModifiedChangesWhenTitleSet()
    {
        $image = new Image;
        $modified_1 = $image->getLastModified();
        $image->setTitle('One');
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
        $this->givenAFile();
        $image->setFile($this->file);
    }

    public function testImageFileIsNullByDefault()
    {
        $image = new Image;
        $file = $image->getFile();
        $this->assertSame(null, $file);
    }

    public function testLastModifiedChangesWhenFileIsSet()
    {
        $image = new Image;
        $this->givenAFile();
        $modified_1 = $image->getLastModified();
        $image->setFile($this->file);
        $modified_2 = $image->getLastModified();

        $this->assertTrue($modified_1 != $modified_2);
    }
/*
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
*/
    public function testCanSetPath()
    {
        $image = new Image;
        $path = "dir/path/image.png";

        $image->setPath($path);
    }

    public function testLastModifiedChangesWhenPathSet()
    {
        $image = new Image;
        $modified_1 = $image->getLastModified();
        $image->setPath('all-images/one.png');
        $modified_2 = $image->getLastModified();

        $this->assertTrue($modified_1 != $modified_2);
    }

    public function testHashChangesWhenPathSet()
    {
        $image = new Image;
        $image->setPath('all-images/one.png');
        $hash_1 = $image->getHash();
        $image->setPath('all-images/two.png');
        $hash_2 = $image->getHash();

        $this->assertTrue($hash_1 != $hash_2);
    }

    public function getSlugs()
    {
        return [
            ['Title', 'title'],
            ['A long and informative   title', 'a-long-and-informative-title'],
            ['a title_with_underscores', 'a-title-with-underscores'],
            ['&?#image name', '-image-name']
        ];
    }

    /**
    * @dataProvider getSlugs
    */
    public function testImageSlugMatchesTitle($title, $slug)
    {
        $image = new Image;
        $image->setTitle($title);
        $this->assertSame($slug, $image->getSlug());
    }
    
    public function testMimeTypeComesFromFile()
    {
        $this->givenAFile();
        $image = new Image;
        $image->setFile($this->file);
        $this->assertSame($this->file->getMimeType(), $image->getMimeType());
    }
    
    public function testExtensionComesFromFile()
    {
        $this->givenAFile();
        $image = new Image;
        $image->setFile($this->file);
        $this->assertSame($this->file->getExtension(), $image->getExtension());
    }
}
