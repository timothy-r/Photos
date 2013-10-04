<?php namespace Ace\Photos;

/**
* @Document
*/
class DoctrineODMImage
{
    /**
    * @Id
    */
    private $id;

    /**
    * @Field(type="string")
    */
    private $name = '';

    /**
    * @Field(type="string")
    */
    private $hash = '';

    /**
    * @Field(type="int")
    */
    private $last_modified;

    /**
    * @Field(type="int")
    */
    private $size = 0;

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

