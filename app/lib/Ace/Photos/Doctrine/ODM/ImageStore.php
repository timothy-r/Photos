<?php namespace Ace\Photos\Doctrine\ODM;

use Ace\Photos\IImage;
use Ace\Photos\Doctrine\ODM\IConfig;
use Ace\Photos\IImageStore;

use Doctrine\ODM\MongoDB\MongoDBException;

/**
* A Doctrine ODM store for Images
* convert to use a Doctrine repository not the document manager
*/
class ImageStore implements IImageStore
{
    protected $dm;

    public function __construct(IConfig $config)
    {
        $this->dm = $config->getDocumentManager();
    }

    public function __destruct()
    {
        if ($this->dm){
            $this->dm->flush();
            $this->dm = null;
        }
    }

    /**
    * Add the parameter Image to the store
    *
    * @return boolean
    */
    public function add(IImage $image)
    {
        try {
            $this->dm->persist($image);
            $this->dm->flush();
            return true;
        } catch (MongoDBException $ex) {
            return false;
        }
    }

    /**
    * Update the stored Image data
    *
    * @return boolean
    */
    public function update(IImage $image)
    {
        try {
            $this->dm->persist($image);
            return true;
        } catch (MongoDBException $ex) {
            return false;
        }
    }
    
    /**
    * Get an array of all the Images in the store
    *
    * @return array
    */
    public function all()
    {
        return $this->dm->createQueryBuilder('Ace\Photos\Doctrine\ODM\Image')->getQuery()->execute()->toArray();
    }

    /**
    * Get an Image by its slug 
    *
    * @return Image
    */
    public function get($slug)
    {
        return $this->dm->getRepository('Ace\Photos\Doctrine\ODM\Image')->findOneBy(['slug' => $slug]);
    }

    /**
    * Remove the parameter Image from the store
    */
    public function remove(IImage $image)
    {
        $this->dm->remove($image);
    }
}
