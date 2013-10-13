<?php namespace Ace\Photos;

use SplFileInfo;
use Ace\Photos\IImageFactory;
use Ace\Photos\DoctrineODMImage as Image;

/**
* Creates instances of Image
*/
class DoctrineODMImageFactory implements IImageFactory
{
    public function create($title, SplFileInfo $file)
    {
        $image = new Image;
        $image->setTitle($title);
        $image->setFile($file);
        return $image;
    }
}
