<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit39b51a3edf7841b32f3138baf566ab7b
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Carbon_Fields\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Carbon_Fields\\' => 
        array (
            0 => __DIR__ . '/..' . '/htmlburger/carbon-fields/core',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit39b51a3edf7841b32f3138baf566ab7b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit39b51a3edf7841b32f3138baf566ab7b::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit39b51a3edf7841b32f3138baf566ab7b::$classMap;

        }, null, ClassLoader::class);
    }
}
