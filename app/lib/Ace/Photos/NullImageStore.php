<?php
namespace Ace\Photos;
use Ace\Photos\IImageStore;
use Ace\Photos\Image;

/**
* A null repository for Images
*/
class NullImageStore implements IImageStore
{
    
    public function add(Image $image)
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

    public function remove(Image $image)
    {

    }
}
