<?php namespace Ace\Photos;

use Ace\Photos\IImage;
use Ace\Photos\IDoctrineODMConfig;
use Ace\Photos\DoctrineODMImage as Image;
use Ace\Photos\IImageStore;

/**
* A Doctrine ODM store for Images
* convert to use a Doctrine repository not the document manager
*/
class DoctrineODMImageStore implements IImageStore
{
    protected $dm;

    public function __construct(IDoctrineODMConfig $config)
    {
        $this->dm = $config->getDocumentManager();
    }

    public function __destruct()
    {
        $this->dm->flush();
    }

    /**
    * Add the parameter Image to the store
    *
    * @return boolean
    */
    public function add(IImage $image)
    {
        $this->dm->persist($image);
    }

    /**
    * Update the stored Image data
    *
    * @return boolean
    */
    public function update(IImage $image)
    {
        $this->dm->persist($image);
    }
    
    /**
    * Get an array of all the Images in the store
    *
    * @return array
    */
    public function all()
    {
        return $this->dm->createQueryBuilder('Ace\Photos\DoctrineODMImage')->getQuery()->execute()->toArray();
    }

    /**
    * Get an Image by its id 
    *
    * @return Image
    */
    public function get($id)
    {
        return $this->dm->find('Ace\Photos\DoctrineODMImage', $id);
    }

    /**
    * Remove the parameter Image from the store
    * @return boolean
    */
    public function remove(IImage $image)
    {
        $this->dm->remove($image);
    }
}
