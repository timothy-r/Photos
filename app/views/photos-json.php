<?php
/**
* json view of an array of Photos
*/
// this prints headers into the response body...
echo Response::make(
    Response::json($photos),
    200, 
    array('Content-Type' => 'application/json')
);

