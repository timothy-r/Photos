<?php namespace Ace\Photos;

use Ace\Photos\IImageFactory;
use Ace\Photos\DoctrineODMImage as Image;

/**
* Creates instances of Image
*/
class DoctrineODMImageFactory implements IImageFactory
{
    public function create($title)
    {
        $image = new Image;
        $image->setTitle($title);
        return $image;
    }
}


