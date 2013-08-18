<?php namespace Ace\Photos;

use Illuminate\Support\ServiceProvider;

/**
*/
class PhotoViewServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'Ace\Photos\IPhotoView',
            'Ace\Photos\PhotoView'
        );
    }
}
