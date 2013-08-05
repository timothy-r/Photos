<?php
namespace Ace\Photos;

/**
* Represents a single Image document
*/
class Image
{
    /**
    * A unique identifier for this instance
    *
    * @var string
    */
    protected $id;

    /**
    * @var string
    */
    protected $name = '';

    /**
    * @var string
    */
    protected $hash;

    /**
    * @var integer
    */
    protected $last_modified;
    
    /**
    * The size of the Image this class contains in bytes
    * @var integer
    */
    protected $size = 0;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        if (!isset($this->id)){
            $this->id = $id;
        }
    }

    public function getName()
    {
        return $this->name;    
    }

    public function setName($name)
    {
        $this->name = $name;
        $this->changed();
    }

    public function getHash()
    {
        return $this->hash;
    }

    public function getLastModified()
    {
        return $this->last_modified;
    }
   
    public function getSize()
    {
        return $this->size;
    }

    /**
    * The Image state has changed, update bookkeeping data
    */
    protected function changed()
    {
        $this->hash = md5("Ace\Photos\Image::{$this->name}");
        $this->last_modified = time();
    }
}

