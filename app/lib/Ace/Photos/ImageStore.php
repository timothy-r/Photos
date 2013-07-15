<?php
namespace Ace\Photos;
use Ace\Photos\IImageStore;

/**
* A repository for Images
*/
class ImageStore implements IImageStore
{
    
    public function add(Image $image)
    {
        return true;
    }

    public function all()
    {
        return array();
    }
}
