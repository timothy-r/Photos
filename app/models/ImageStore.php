<?php
namespace Ace\Photos;

/**
* A repository for Images
*/
class ImageStore
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
