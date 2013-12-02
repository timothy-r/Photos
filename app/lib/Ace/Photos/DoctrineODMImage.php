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
    private $path = '';

    /**
    * @ODM\File
    */
    private $file;

    /**
    * @ODM\Field(type="string")
    */
    private $mime_type;

    /**
    * Url friendly version of title
    * Must be unique, used as identifier to access the Image
    *
    * @ODM\String @ODM\Index(unique="true")
    */
    private $slug;

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
        $this->setSlug();
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
        $this->path = $path;
        $this->changed(); 
    }

    /**
    * @param string $file - file on disc to store in gridfs
    */
    public function setFile($file)
    {
        $this->file = $file;
        $this->changed(); 
    }

    /**
    * @return the file
    */
    public function getFile()
    {
        return $this->file;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    protected function setSlug()
    {
        $this->slug = preg_replace('#[\W_]+#', '-', strtolower($this->title));
    }

    /**
    * The Image state has changed, update bookkeeping data
    */
    protected function changed()
    {
        $this->hash = md5(__CLASS__ . "::{$this->title}:{$this->path}");
        $this->last_modified = time();
    }
}

