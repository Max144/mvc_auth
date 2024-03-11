<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita43f6ec9a4f924d6c8f71112ba4b322c
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'AdminUser\\MvcTest\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'AdminUser\\MvcTest\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInita43f6ec9a4f924d6c8f71112ba4b322c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita43f6ec9a4f924d6c8f71112ba4b322c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInita43f6ec9a4f924d6c8f71112ba4b322c::$classMap;

        }, null, ClassLoader::class);
    }
}
