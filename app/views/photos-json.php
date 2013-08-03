<?php
/**
* json view of an array of Photos
*/

echo Response::make(
    Response::json($photos),
    200, 
    array('Content-Type' => 'application/json')
);

