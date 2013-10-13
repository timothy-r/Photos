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
    private $title = '';

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
   
    /**
    * @ODM\Field(type="string")
    */
    private $path = '';

    /**
    * @ODM\File
    */
    private $file;

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
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
   
    public function setPath($path)
    {
    }

    /**
    * @param string $filename location of file in 'virtual store'
    * @param string $file - file on disc to store in gridfs
    */
    public function setFile($filename, $file)
    {
        $this->filename = $filename;
        $this->changed(); 
    }

    /**
    * The Image state has changed, update bookkeeping data
    */
    protected function changed()
    {
        $this->hash = md5("Ace\Photos\DoctrineODMImage::{$this->title}:{$this->filename}");
        $this->last_modified = time();
    }
}

