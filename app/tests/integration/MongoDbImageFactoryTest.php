<?php
use Ace\Photos\MongoDbImageFactory as Factory;

class MongoDbImageFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCanCreateMongoDbImage()
    {
        // pick any real directory and file name
        $path = __DIR__ . '/Image_tmp.jpg';
        $factory = $this->getMock('Ace\Photos\MongoDbImageFactory', ['getStoragePath']);
        $factory->expects($this->any())
            ->method('getStoragePath')
            ->will($this->returnValue($path));

        $name = 'What a wonderful panorama';
        $file = $this->getMock('Symfony\Component\HttpFoundation\File\UploadedFile', ['getExtension', 'move'], [], '', false);
        $file->expects($this->any())
            ->method('getExtension')
            ->will($this->returnValue('jpg'));

        $result = $factory->create($name, $file);
        $this->assertInstanceOf('\Ace\Photos\Image', $result);
        $this->assertSame($name, $result->getName());
    }
}
