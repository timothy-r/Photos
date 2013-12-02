<?php namespace Ace\Photos;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Ace\Photos\IImageFactory;
use Ace\Photos\DoctrineODMImage as Image;

/**
* Creates instances of Image
*/
class DoctrineODMImageFactory implements IImageFactory
{
    public function create($title, UploadedFile $file)
    {
        $image = new Image;
        $image->setTitle($title);
        $image->setFile($file);
        return $image;
    }
}
