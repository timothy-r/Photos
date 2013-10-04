<?php
namespace Ace\Photos;

use Illuminate\Support\ServiceProvider;

/**
* It's approriate to bind two services here as we always want them bound together
*
* Consider this to be a version of abstract factory
*
* Binds the DoctrineODMImageStore class to the IImageStore interface
* Binds the DoctrineODMImageFactory class to the IImageFactory interface
*/
class DoctrineODMImageServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'Ace\Photos\IImageStore',
            'Ace\Photos\DoctrineODMImageStore'
        );
        
        $this->app->bind(
            'Ace\Photos\IImageFactory',
            'Ace\Photos\DoctrineODMImageFactory'
        );
        
    }
}
