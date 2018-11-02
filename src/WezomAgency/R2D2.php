<?php

namespace WezomAgency;


class R2D2
{
    /** @type string */
    private static $rootPath = '';

    /** @type string */
    private static $host = '';

    /** @type string */
    private static $protocol = 'http://';

    /**
     * @param string $rootPath
     */
    public static function setRootPath($rootPath)
    {
        self::$rootPath = $rootPath;
    }

    /**
     * @return string
     */
    public static function getRootPath()
    {
        return self::$rootPath;
    }

    /**
     * @param string $host
     */
    public static function setHost ($host)
    {
        self::$host = $host;
    }

    /**
     * @return string
     */
    public static function getHost ()
    {
        return self::$host;
    }

    /**
     * @param string $protocol
     */
    public static function setProtocol ($protocol)
    {
        self::$protocol = $protocol;
    }

    /**
     * @return string
     */
    public static function getProtocol ()
    {
        return self::$protocol;
    }

    /**
     * @param string $url
     * @param boolean $timestamp
     * @param boolean $absolute
     * @return string
     */
    public static function fileUrl ($url, $timestamp = false, $absolute = false)
    {
        $file = trim($url, '/');
        return implode('', [
            $absolute ? (self::getProtocol() . self::getHost()) : '/',
            $file,
            $timestamp ? ('?time' . fileatime(self::getRootPath() . $file)) : ''
        ]);
    }

    /**
     * @param string $path
     * @return bool|string
     */
    public static function fileContent ($path)
    {
        $path = self::fileUrl($path, false, false);
        return file_get_contents(self::getRootPath() . $path);
    }
}
