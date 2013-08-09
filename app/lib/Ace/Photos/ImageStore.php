<?php
namespace Ace\Photos;
use Ace\Photos\IImageStore;

/**
* A repository for Images
*/
class ImageStore implements IImageStore
{
    /**
    * Add the parameter Image to the store
    *
    * @return boolean
    */
    public function add(Image $image)
    {
        return $image->save();
    }
    
    /**
    * Get an array of all the Images in the store
    *
    * @return array
    */
    public function all()
    {
        return [];
    }

    public function get($id)
    {

    }
}
