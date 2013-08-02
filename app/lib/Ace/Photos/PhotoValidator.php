<?php
namespace Ace\Photos;
use Ace\Photos\IImageStore;

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

    public function validate($name)
    {
        $validator = \Validator::make(
            array('name' => $name),
            array('name' => 'required')
        );
        
        return $validator->passes();
    }

    public function validateExists($id)
    {
        return false;        
    }
}
