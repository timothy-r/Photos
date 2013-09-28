<?php namespace Ace\Photos;

use Ace\Photos\IImageFactory;
use Ace\Photos\Image;

/**
* Creates instances of Image
* Deal with handling uploaded Image files
*/
class MongoDbImageFactory implements IImageFactory
{
    /**
    * @param string $name
    * @param Symfony\Component\HttpFoundation\File\UploadedFile $file
    *
    * file is moved to a temp location, added to mongo and removed
    */
    public function create($name, $file)
    {
        $image = new Image;
        $image->setName($name);

        // get mime type of image file and set on Image

        // create a target file path and name
        $path = $this->getStoragePath($file);

        $parts = pathinfo($path);
        
        // move it
        $file->move($parts['dirname'], $parts['basename']);

        // pass temp file to Image
        $image->setFile($path);

        // remove temp file

        // return Image object
        return $image;
    }

    protected function getStoragePath($file)
    {
        $path = storage_path();
        return tempnam($path, 'Image_') . '.' . $file->guessExtension();
    }
}
