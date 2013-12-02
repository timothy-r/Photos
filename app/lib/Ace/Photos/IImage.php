<?php namespace Ace\Photos;

use SplFileInfo;

/**
* The interface that Images must implement
*/
interface IImage 
{
    /**
    * @return string the identifier of this instance
    */
    public function getId();

    /**
    * @return string
    */
    public function getTitle();

    /**
    * sets the title property of this instance
    */
    public function setTitle($name);

    /**
    * set the virtual path to the Image
    * @param string $path
    */
    public function setPath($path);

    /**
    * store the $file data in gridfs
    * @param string path to the local file
    */
    public function setFile(SplFileInfo $file);

    /**
    * Returns a hash of this Image's state
    *
    * @return string
    */
    public function getHash();

    /**
    * Unix timestamp when this Image was last changed
    *
    * @return integer
    */
    public function getLastModified();
   
    /**
    * Return the size in bytes of the Image data
    *
    * @return integer
    */
    public function getSize();

    public function getSlug();

    /**
    * @return string the Image's mime type, eg. image/png
    */
    public function getMimeType();
}

