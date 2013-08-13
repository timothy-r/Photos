<?php namespace Ace\Photos;

use Ace\Photos\IImage;
use Ace\Photos\IPhotoView;
use Response;
use DateTime;
use View;
use URL;

class PhotoViewer implements IPhotoView
{
    protected $get_photo_data;

    public function __construct()
    {
        $this->get_photo_data = function(IImage $image){
            return [
                'id' => $image->getId(),
                'name' => $image->getName(),
                'last_modified' => $image->getLastModified(),
                'hash' => $image->getHash(),
                'uri' => URL::action('PhotoController@show', [$image->getId()])
            ];
        };
    }

    public function makeAcceptable(IImage $image)
    {
        $data = call_user_func($this->get_photo_data, $image);
        $headers = $this->headers($image);
        return $this->getResponse('photo', ['photo' => $data], $headers);
    }

    public function makeManyAcceptable(array $images)
    {
        $data = array_map($this->get_photo_data, $images);
        return $this->getResponse('photos', ['photos' => $data], []);
    }

    protected function getResponse($name, $data, $headers)
    {
        // get best response format
        $type = $this->getAcceptableContentType();

        if ($type === 'text/html') {
            $headers['Content-Type'] = 'text/html';
            return Response::make(View::make($name, $data), 200, $headers);
        } else if ($type === 'application/json') {
            return Response::json($data, 200, $headers);
        } else {
            return Response::make('', 406);
        }
    }

    protected function getAcceptableContentType()
    {
        $negotiator = \App::make('\Negotiation\FormatNegotiator');
        $format = $negotiator->getBest(\Request::header('Accept'), ['text/html', 'application/json']);
        return $format->getValue(); 
    }

    public function notFound($id)
    {
        return Response::make('', 404);
    }
    
    public function notModified(IImage $image)
    {
        $response = Response::make('', 304, $this->headers($image));
        $response->setNotModified();
        return $response;
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
