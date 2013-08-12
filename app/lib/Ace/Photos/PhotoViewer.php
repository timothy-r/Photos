<?php namespace Ace\Photos;

use Ace\Photos\IImage;
use Ace\Photos\IPhotoView;
use Response;
use DateTime;

class PhotoViewer implements IPhotoView
{
    public function notFound($id)
    {
        return Response::make('', 404);
    }
    
    public function notModified(IImage $image)
    {
        return Response::make('', 304, $this->headers($image));
    }

    public function preconditionFailed(IImage $image)
    {
        return Response::make('', 412, $this->headers($image));
    }

    protected function headers(IImage $image)
    {
        $headers = [];
        $headers['ETag'] = $image->getHash();
        $last_modified = new DateTime('GMT');
        $last_modified->setTimestamp($image->getLastModified());
        $headers['Last-Modified'] = http_date($last_modified);
        return $headers;
    }
}
