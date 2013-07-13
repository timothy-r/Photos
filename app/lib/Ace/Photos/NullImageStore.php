<?php
namespace Ace\Photos;
use Ace\Photos\IImageStore;

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
}
