<?php
namespace Ace\Photos;

/**
* represents a single Image document
*/
class Image
{
    /**
    * A unique identifier for this instance
    *
    * @var string
    */
    protected $id;

    protected $name;

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
    }

    public function getHash()
    {
    }
}

