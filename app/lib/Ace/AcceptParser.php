<?php namespace Ace;

class AcceptParser
{
    /**
    * test if the $header accepts $mime
    * @return boolean
    */
    public function isAcceptable($mime, $header)
    {
        return in_array($mime, array_map('trim', explode(',', $header)));
    }
}
