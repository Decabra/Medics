<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbca3e300fca56d1886c12ead5792e87a
{
    public static $prefixLengthsPsr4 = array (
        'D' => 
        array (
            'Delight\\Http\\' => 13,
            'Delight\\Cookie\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Delight\\Http\\' => 
        array (
            0 => __DIR__ . '/..' . '/delight-im/http/src',
        ),
        'Delight\\Cookie\\' => 
        array (
            0 => __DIR__ . '/..' . '/delight-im/cookie/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitbca3e300fca56d1886c12ead5792e87a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitbca3e300fca56d1886c12ead5792e87a::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
