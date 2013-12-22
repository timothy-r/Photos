<?php namespace Ace\Photos\Null;

use Illuminate\Support\ServiceProvider;

/**
* Binds the NullImageStore class to the IImageStore interface
*/
class ImageStoreServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'Ace\Photos\IImageStore',
            'Ace\Photos\Null\ImageStore'
        );
    }
}
