<?php namespace Ace\Photos\Doctrine;

use Ace\Photos\IDoctrineODMConfig;

use Doctrine\Common\ClassLoader,
    Doctrine\Common\Annotations\AnnotationReader,
    Doctrine\ODM\MongoDB\DocumentManager,
    Doctrine\MongoDB\Connection,
    Doctrine\ODM\MongoDB\Configuration,
    Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;

class ODMConfig implements IDoctrineODMConfig
{
    /**
    * @return Doctrine\ODM\MongoDB\DocumentManager
    */
    public function getDocumentManager()
    {
        $storage = storage_path();
        $config = new Configuration();
        $config->setProxyDir($storage . '/cache');
        $config->setProxyNamespace('Proxies');

        $config->setHydratorDir($storage . '/cache');
        $config->setHydratorNamespace('Hydrators');

        $reader = new AnnotationReader();

        $driver = new AnnotationDriver($reader, __DIR__.'/Documents');
        $driver->registerAnnotationClasses();
        $config->setMetadataDriverImpl($driver);

        return DocumentManager::create(new Connection(), $config);
    }
}
