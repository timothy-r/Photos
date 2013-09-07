<?php namespace Ace\Photos;

use Purekid\Mongodm\Model;
use Ace\Photos\IImage;
use Log;
use Config;

/**
* Represents a single Image document
*/
class Image extends Model implements IImage
{
    
    /**
    * where Image documents are stored
    */
    protected static $collection = 'image';
  
    public static $config;

    /**
    * persisted attributes
    */ 
    protected static $attrs = array(
        'name' => array('type'=>'string', 'default' => ''),
        'hash' => array('type'=>'string', 'default' => ''),
        'last_modified' => array('type'=>'integer'),
        'size' => array('type'=>'integer', 'default' => 0),
    );

    public function __construct($data = [])
    {
        #$name = Config::get('database.default');
        #$config = Config::get('database.' .$name);
        #static::$config = $config['connection']['database'];

        Log::info(__METHOD__. " " . static::$config);
        parent::__construct($data);
    }

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

