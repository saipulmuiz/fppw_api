<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0bad34b12931396eae1a796f835a71ad
{
    public static $prefixLengthsPsr4 = array (
        'c' => 
        array (
            'chriskacerguis\\RestServer\\' => 26,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'chriskacerguis\\RestServer\\' => 
        array (
            0 => __DIR__ . '/..' . '/chriskacerguis/codeigniter-restserver/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0bad34b12931396eae1a796f835a71ad::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0bad34b12931396eae1a796f835a71ad::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
