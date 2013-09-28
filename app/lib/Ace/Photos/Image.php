<?php namespace Ace\Photos;

use Purekid\Mongodm\MongoDB;
use Purekid\Mongodm\Model;
use Ace\Photos\IImage;
use Log;
use Config;

/**
* Represents a single Image document stored in MongoDb
*/
class Image extends Model implements IImage
{
    /**
    * the collection where Image documents are stored
    */
    protected static $collection = 'image';
  
    public static $config;

    /**
    * persisted attributes
    */ 
    protected static $attrs = [
        'name'          => ['type'=>'string', 'default' => ''],
        'hash'          => ['type'=>'string', 'default' => ''],
        'last_modified' => ['type'=>'integer'],
        'size'          => ['type'=>'integer', 'default' => 0],
        'filename'      => ['type'=>'string', 'default' => ''],
    ];

    public static function setConfig($config)
    {
        static::$config = $config;
    }

    /**
    * @todo remove
    */
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

    /**
    * @todo use di to set the MongoDB instance on this class
    * so we can mock it for testing
    */
    public function setFile($filename)
    {
        $this->filename = $filename;
        // add file to grid fs
        $result = MongoDB::instance()->set_file($this->filename);
        $this->changed();
    }

    public function getFile()
    {
        
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
    * @todo add the file contents to the hash
    */
    protected function changed()
    {
        $this->hash = md5("Ace\Photos\Image::{$this->name}.{$this->filename}");
        $this->last_modified = time();
    }
}

