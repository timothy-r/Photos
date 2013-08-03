<?php namespace Ace\Photos;

use Ace\Photos\Image;

/**
* Validates $id parameter;
*/
class PhotoExistsValidator
{
    protected $store;

    public function __construct(IImageStore $store)
    {
        $this->store = $store;
    }

    public function validate($id)
    {
        return $this->store->get($id) instanceof Image;
    }
}
