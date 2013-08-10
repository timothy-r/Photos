<?php
namespace Ace\Photos;

/**
* Represents a single Image document
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
    public function getName();

    /**
    * sets the name property of this instance
    */
    public function setName($name);

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

