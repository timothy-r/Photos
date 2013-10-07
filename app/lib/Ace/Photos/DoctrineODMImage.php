<?php namespace Ace\Photos;

use Ace\Photos\IImage;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
* @ODM\Document
*/
class DoctrineODMImage implements IImage
{
    /**
    * @ODM\Id
    */
    private $id;

    /**
    * @ODM\Field(type="string")
    */
    private $name = '';

    /**
    * @ODM\Field(type="string")
    */
    private $hash = '';

    /**
    * @ODM\Field(type="int")
    */
    private $last_modified;

    /**
    * @ODM\Field(type="int")
    */
    private $size = 0;

    public function getId()
    {
        return $this->id;
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
        $this->hash = md5("Ace\Photos\DoctrineODMImage::{$this->name}");
        $this->last_modified = time();
    }
}

