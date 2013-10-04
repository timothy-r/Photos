<?php namespace Ace\Photos;

use Ace\Photos\IImageFactory;
use Ace\Photos\DoctrineODMImage as Image;

/**
* Creates instances of Image
*/
class DoctrineODMImageFactory implements IImageFactory
{
    public function create($name)
    {
        $image = new Image;
        $image->setName($name);
        return $image;
    }
}


