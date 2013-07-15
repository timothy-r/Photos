<?php
namespace Ace\Photos;

use Illuminate\Support\ServiceProvider;

/**
* Binds the NullImageStore class to the IImageStore interface
*/
class NullImageStoreServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'Ace\Photos\IImageStore',
            'Ace\Photos\NullImageStore'
        );
    }
}
