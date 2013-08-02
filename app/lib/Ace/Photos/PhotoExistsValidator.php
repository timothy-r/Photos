<?php namespace Ace\Photos;

/**
* Validates $id parameter
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

    }
}
