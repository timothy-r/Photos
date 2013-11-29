<?php namespace Ace;

/**
* Deals with comparing If-Match and If-None-Match HTTP request header values against ETag strings 
*/
class EntityHandler
{
    /**
    * Tests if the etag param matches the If-Match or If-None-Match request header value
    *
    * @param string $header the value from the request header
    * @param string $etag the etag for the resource
    * @return boolean
    */
    public function matches($header, $etag)
    {
        return (($header === $etag) || ('*' === $header));
    }
}
