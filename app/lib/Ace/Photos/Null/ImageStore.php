<?php namespace Ace\Photos\Null;

use Ace\Photos\IImageStore;
use Ace\Photos\IImage;

/**
* A null repository for Images
*/
class ImageStore implements IImageStore
{
    
    public function init(){}

    public function add(IImage $image)
    {
        return true;
    }
    
    public function update(IImage $image)
    {
        return true;
    }

    public function all()
    {
        return array();
    }

    public function get($id)
    {
        return null;
    }

    public function remove(IImage $image)
    {
        return true;
    }
}
