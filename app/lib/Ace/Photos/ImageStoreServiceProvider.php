<?php
namespace Ace\Photos;

use Illuminate\Support\ServiceProvider;

/**
* Binds the ImageStore class to the IImageStore interface
*/
class ImageStoreServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'Ace\Photos\IImageStore',
            'Ace\Photos\ImageStore'
        );
    }
}
