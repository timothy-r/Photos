<?php namespace Ace\Photos;

use Ace\Photos\IImage;
use Ace\Photos\DoctrineODMImage as Image;
use Ace\Photos\IImageStore;

#use Config;
#use Log;

/**
* A MongoDB repository for Images
*/
class DoctrineODMImageStore implements IImageStore
{
    
    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        /*
        Log::info(__METHOD__);
        // initialize the MongoDb connection here
        $name = Config::get('database.default');
        $config = Config::get('database.' .$name);
        $db = MongoDB::instance($name, $config);
        Image::setConfig($config['connection']['database']);
        */
    }

    /**
    * Add the parameter Image to the store
    *
    * @return boolean
    */
    public function add(IImage $image)
    {
    }

    /**
    * Update the stored Image data
    *
    * @return boolean
    */
    public function update(IImage $image)
    {
    }
    
    /**
    * Get an array of all the Images in the store
    *
    * @return array
    */
    public function all()
    {
    }

    /**
    * Get an Image by its id 
    *
    * @return Image
    */
    public function get($id)
    {
    }

    /**
    * Remove the parameter Image from the store
    * @return boolean
    */
    public function remove(IImage $image)
    {
    }
}
