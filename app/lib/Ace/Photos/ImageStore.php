<?php namespace Ace\Photos;

use Purekid\Mongodm\MongoDB;
use Ace\Photos\IImageStore;
use Config;

/**
* A MongoDB repository for Images
*/
class ImageStore implements IImageStore
{
    
    public function __construct()
    {
        // initialize the MongoDb connection here
        $name = Config::get('database.default');
        $config = Config::get('database.' .$name);
        $db = MongoDB::instance($name, $config);
    }

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
        return Image::all()->toArray(false);
    }

    /**
    * Get an Image by its id 
    *
    * @return Image
    */
    public function get($id)
    {
        return Image::id($id);
    }

    /**
    * Remove the parameter Image from the store
    * @return boolean
    */
    public function remove(Image $image)
    {
        return $image->delete();
    }
}
