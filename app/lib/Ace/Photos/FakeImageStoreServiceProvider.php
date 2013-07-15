<?php
namespace Ace\Photos;

use Illuminate\Support\ServiceProvider;

/**
* Binds the FakeImageStore class to the IImageStore interface
*/
class FakeImageStoreServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'Ace\Photos\IImageStore',
            'Ace\Photos\FakeImageStore'
        );
    }
}
