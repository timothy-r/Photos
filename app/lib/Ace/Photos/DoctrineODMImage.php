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
    * rename to title?/label?
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

    /**
    * @ODM\Field(type="string")
    */
    private $filename = '';

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
    * @param string $filename location of file in 'virtual store'
    * @param string $file - file on disc to store in gridfs
    */
    public function setFile($filename)
    {
        $this->filename = $filename;
        $this->changed(); 
    }

    /**
    * The Image state has changed, update bookkeeping data
    */
    protected function changed()
    {
        $this->hash = md5("Ace\Photos\DoctrineODMImage::{$this->name}:{$this->filename}");
        $this->last_modified = time();
    }
}

