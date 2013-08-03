<?php namespace Ace;

/**
*
*/
class AcceptParser
{
    /**
    * @var array
    */
    protected $header;

    public function __construct($header)
    {
        $this->header = array_map('trim', explode(',', $header));
    }

    /**
    * test if the $header accepts $mime
    * @return boolean
    */
    public function isAcceptable($mime)
    {
        return in_array($mime, $this->header);
    }
}
