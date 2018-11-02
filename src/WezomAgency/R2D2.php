<?php

namespace WezomAgency;

class R2D2
{
    /** @type string */
    private static $rootPath = '';

    /** @param string $rootPath */
    public static function setRootPath($rootPath) {
        self::$rootPath = $rootPath;
    }

    /** @return string */
    public static function getRootPath() {
        return self::$rootPath;
    }

    

    /** @type string */
    private static $host = '';

    /** @param string $host */
    public static function setHost ($host) {
        self::$host = $host;
    }

    /** @return string */
    public static function getHost () {
        return self::$host;
    }

    

    /** @type string */
    private static $protocol = 'http://';

    /** @param string $protocol */
    public static function setProtocol ($protocol) {
        self::$protocol = $protocol;
    }

    /** @return string */
    public static function getProtocol () {
        return self::$protocol;
    }

    

    /**
     * @param string $url
     * @param boolean $timestamp
     * @param boolean $absolute
     * @return string
     */
    public static function fileUrl ($url, $timestamp = false, $absolute = false) {
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
    public static function fileContent ($path) {
        $path = self::fileUrl($path, false, false);
        return file_get_contents(self::getRootPath() . $path);
    }



    /**
     * @inspired by https://github.com/LaravelCollective/html
     * @param string $name
     * @param string $value
     * @return string
     */
    public function attribute($name, $value) {
        if (is_numeric($name)) {
            return $value;
        }

        if (is_bool($value) && $name !== 'value') {
            return $value ? $name : '';
        }

        if (is_array($value) && $name === 'class') {
            return 'class="' . implode(' ', $value) . '"';
        }

        if (!is_null($value)) {
            $text = strip_tags($value);
            return $name . '="' . htmlspecialchars($text, ENT_QUOTES, 'UTF-8', false) . '"';
        }
    }

    /**
     * @param array $attributes
     * @return string
     */
    public static function attributes ($attributes) {
        $html = [];
        foreach ($attributes as $name => $value) {
            $element = self::attribute($name, $value);
            if (!is_null($element)) {
                $html[] = $element;
            }
        }
        return count($html) > 0 ? ' ' . implode(' ', $html) : '';
    }
}
