<?php namespace Ace\Photos\Doctrine\ODM;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Ace\Photos\IImageFactory;
use Ace\Photos\Doctrine\ODM\Image;

/**
* Creates instances of Image
*/
class ImageFactory implements IImageFactory
{
    public function create($title, UploadedFile $file)
    {
        $image = new Image;
        $image->setTitle($title);
        $image->setFile($file);
        return $image;
    }
}
