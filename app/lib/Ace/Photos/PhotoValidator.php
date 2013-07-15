<?php
namespace Ace\Photos;

/**
* Validates incoming Photo data
*/
class PhotoValidator
{

    public function validate($name)
    {
        $validator = \Validator::make(
            array('name' => $name),
            array('name' => 'required')
        );
        
        return $validator->passes();
    }
}
