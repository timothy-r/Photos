<?php namespace Ace\Photos;

use Ace\Photos\IImageFactory;
use Ace\Photos\Image;

/**
* Creates instances of Image
*/
class MongoDbImageFactory implements IImageFactory
{
    public function create($name)
    {
        $image = new Image;
        $image->setName($name);
        return $image;
    }
}

