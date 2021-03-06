<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6b239028fc84211c257cfc8284b26c12
{
    public static $prefixLengthsPsr4 = array (
        'B' => 
        array (
            'BigBlueButton\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'BigBlueButton\\' => 
        array (
            0 => __DIR__ . '/..' . '/bigbluebutton/bigbluebutton-api-php/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6b239028fc84211c257cfc8284b26c12::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6b239028fc84211c257cfc8284b26c12::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
