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

    protected $name;

    protected $hash;

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
        $this->setHash();
    }

    public function getHash()
    {
        return $this->hash;
    }

    protected function setHash()
    {
        $this->hash = md5("{$this->name}");
    }
}

