<?php
namespace Ace\Photos;
use Ace\Photos\IImageStore;
use Ace\Photos\Image;

/**
* Validates incoming Photo data
*/
class PhotoValidator
{
    /**
    * @var Ace\Photos\IImageStore
    */
    protected $store;

    /**
    * @param Ace\Photos\IImageStore $store
    */
    public function __construct(IImageStore $store)
    {
        $this->store = $store;
    }

    /**
    * Test that name is a valid name for an Image
    *
    * @param string $name 
    * @return boolean
    */
    public function validate($name)
    {
        $validator = \Validator::make(
            array('name' => $name),
            array('name' => 'required')
        );
        
        return $validator->passes();
    }

    /**
    * Test that an Image identified by $id exists
    * @return boolean
    */
    public function validateExists($id)
    {
        return $this->store->get($id) instanceof Image;
    }
}
