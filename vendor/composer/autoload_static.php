<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbe3d88a266d279caac73739777c24480
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Mostafax2\\Knet\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Mostafax2\\Knet\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitbe3d88a266d279caac73739777c24480::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitbe3d88a266d279caac73739777c24480::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitbe3d88a266d279caac73739777c24480::$classMap;

        }, null, ClassLoader::class);
    }
}
