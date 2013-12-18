<?php namespace Ace\Photos\Doctrine;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Ace\Photos\IImageFactory;
use Ace\Photos\Doctrine\ODMImage as Image;

/**
* Creates instances of Image
*/
class ODMImageFactory implements IImageFactory
{
    public function create($title, UploadedFile $file)
    {
        $image = new Image;
        $image->setTitle($title);
        $image->setFile($file);
        return $image;
    }
}
