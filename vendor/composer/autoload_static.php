<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit7fcc5ec52790085ae434bb8fa62e4d19
{
    public static $prefixLengthsPsr4 = array (
        'a' => 
        array (
            'app\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'app\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit7fcc5ec52790085ae434bb8fa62e4d19::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit7fcc5ec52790085ae434bb8fa62e4d19::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit7fcc5ec52790085ae434bb8fa62e4d19::$classMap;

        }, null, ClassLoader::class);
    }
}
