<?php
use Ace\Photos\ImageStore;
use Ace\Photos\Image;

class ImageStoreTest extends \PHPUnit_Framework_TestCase
{

    public function testCanAddAnImage()
    {
        $image = new Image;
        $image_store = new ImageStore;
        $result = $image_store->add($image);

    }
}
