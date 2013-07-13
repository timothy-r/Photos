<?php
namespace Ace\Photos;

/**
* represents a single Image document
*/
class Image
{
    protected $name;

    public function getName()
    {
        return $this->name;    
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}

