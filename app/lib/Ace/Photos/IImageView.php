<?php namespace Ace\Photos;

use Ace\Photos\IImage;

interface IImageView
{

    public function makeAcceptable(IImage $image);

    public function makeManyAcceptable(array $images);

    /**
    * Respond with a 404
    *
    * @return Illuminate\Http\Response
    */
    public function notFound($id);

    /**
    * Response with a 304
    *
    * @return Illuminate\Http\Response
    */
    public function notModified(IImage $image);

    
    /**
    * response with a 412
    * @return Illuminate\Http\Response
    */
    public function preconditionFailed(IImage $image);

    /**
    * response with a 406
    * @return Illuminate\Http\Response
    */
    public function notAcceptable();
}
