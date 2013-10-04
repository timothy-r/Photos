<?php namespace Ace\Photos;

use Ace\Photos\IImage;
use Ace\Photos\Image;
use Purekid\Mongodm\MongoDB;
use Ace\Photos\IImageStore;
use Config;
use Log;

/**
* A MongoDB repository for Images
*/
class MongoDbImageStore implements IImageStore
{
    
    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        // initialize the MongoDb connection here
        $name = Config::get('database.default');
        $config = Config::get('database.' .$name);
        $db = MongoDB::instance($name, $config);
        Image::setConfig($config['connection']['database']);
    }

    /**
    * Add the parameter Image to the store
    *
    * @return boolean
    */
    public function add(IImage $image)
    {
        return $image->save();
    }

    /**
    * Update the stored Image data
    *
    * @return boolean
    */
    public function update(IImage $image)
    {
        $result = $image->save();
        if (is_array($result)){
            $result = ($result['err'] === null);
        }
        return $result;
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
    public function remove(IImage $image)
    {
        return $image->delete();
    }
}
