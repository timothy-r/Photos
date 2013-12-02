<?php namespace Ace\Photos;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface IImageFactory
{
    /**
    * @param string $title
    * @param UploadedFile $file the file on the local system
    * @return IImage
    */
    public function create($title, UploadedFile $file);
}
