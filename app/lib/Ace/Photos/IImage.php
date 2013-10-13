<?php
namespace Ace\Photos;

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
}

