<?php
namespace Ace\Photos\Fake;

use Illuminate\Support\ServiceProvider;

/**
* Binds the FakeImageStore class to the IImageStore interface
* This is how IImageStore is resolved by the dic
*/
class ImageStoreServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'Ace\Photos\IImageStore',
            'Ace\Photos\Fake\ImageStore'
        );
    }
}
