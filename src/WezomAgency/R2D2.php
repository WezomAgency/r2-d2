<?php

namespace WezomAgency;

/**
 * Class R2D2
 * @package WezomAgency
 * @version 1.6.11
 * @author Oleg Dutchenko <dutchenko.o.dev@gmail.com>
 * @license MIT
 */
class R2D2
{
    private static $instance = null;

    /**
     * Ejecting R2D2 instance
     * @return R2D2
     */
    public static function eject()
    {
        if (self::$instance instanceof R2D2) {
            return self::$instance;
        }
        return self::$instance = new R2D2();
    }

    /** @type string */
    protected $rootPath = '';
    /** @type string */
    protected $resourceRelativePath = '';
    /** @type string */
    protected $host = '';
    /** @type string */
    protected $protocol = 'http://';
    /** @type string */
    protected $svgSpritemapPath = '';
    /** @type bool */
    protected $debug = false;
    /** @type array */
    protected $fileUrlTimestampsCache = [];
    /** @type array */
    protected $idCache = [];


    /**
     * Setup instance
     * @param string $name
     * @param string $value
     * @return R2D2 $this
     * @throws \Exception
     */
    public function set($name, $value)
    {
        if (property_exists($this, $name) === false) {
            if ($this->debug) {
                throw new \Exception("Property $name does not exist in class " . __CLASS__);
            } else {
                return $this;
            }
        }
        switch ($name) {
            case 'rootPath':
            case 'resourceRelativePath':
                $this->$name = rtrim($value, '/') . '/';
                break;
            default:
                $this->$name = $value;
        }

        return $this;
    }


    /**
     * Generate file URL
     * @param string $url
     * @param boolean $timestamp
     * @param boolean $absolute
     * @return string
     */
    public function fileUrl($url, $timestamp = false, $absolute = false)
    {

        $root = $absolute ? ($this->protocol . $this->host) : '/';
        $root = rtrim($root, '/') . '/';
        $file = trim($url, '/');
        if ($timestamp) {
            if (!isset($this->fileUrlTimestampsCache[$file]) && is_file($this->rootPath . $file)) {
                $this->fileUrlTimestampsCache[$file] = '?time=' . fileatime($this->rootPath . $file);
            }
            $query = isset($this->fileUrlTimestampsCache[$file]) ? $this->fileUrlTimestampsCache[$file] : '';
            return $root . $file . $query;
        }
        return $root . $file;
    }

    /**
     * Get file contents
     * @param string $path
     * @return bool|string
     */
    public function fileContent($path)
    {
        $file = trim($path, '/');
        return file_get_contents($this->rootPath . $file);
    }


    /**
     * This is the same method as {@link fileUrl}.
     * The only difference is in the relative path that is used to create a full URL.
     * This can be useful for frequently used paths that have a large nesting of directories.
     * You can _"save"_ initial part of the path, and specify the rest when calling the method.
     * @param string $url
     * @param boolean $timestamp
     * @param boolean $absolute
     * @return string
     */
    public function resourceUrl($url, $timestamp = false, $absolute = false)
    {
        return $this->fileUrl($this->resourceRelativePath . ltrim($url, '/'), $timestamp, $absolute);
    }

    /**
     * This is the same method as {@link fileContent}.
     * The only difference is in the relative path that is used to create a full path to the file.
     * This can be useful for frequently used paths that have a large nesting of directories.
     * You can _"save"_ initial part of the path, and specify the rest when calling the method.
     * @param string $path
     * @return bool|string
     */
    public function resourceContent($path)
    {
        return $this->fileContent($this->resourceRelativePath . ltrim($path, '/'));
    }


    /**
     * This method is used to convert string attribute values to numbers.
     * @param string $value
     * @param bool $int
     * @return float|int|0 - zero if `$value` includes `%` character
     */
    public function str2number($value = '', $int = false)
    {
        if (strpos($value, '%')) {
            return 0;
        }
        return $int ? intval($value) : floatval($value);
    }


    /**
     * @param $data
     * @return string
     */
    public function attrJsonEncode($data, $options = null)
    {
        return preg_replace('/\'/', '&apos;', json_encode($data, $options));
    }


    /**
     * @param string $value
     * @return string
     */
    public function attrTextValue($value)
    {
        $text = strip_tags(preg_replace('/<br>/', ' ', $value));
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8', false);
    }

    /**
     * @param string $name
     * @param * $value
     * @return string
     */
    public function attr($name, $value)
    {
        if (is_numeric($name)) {
            return $value;
        }

        if (is_bool($value) && $name !== 'value') {
            return $value ? $name : '';
        }

        if (is_array($value) && $name === 'style') {
            $css = $this->cssRules($value);
            return $css ? 'style="' . $css . '"' : '';
        }

        if (is_array($value) && $name === 'class') {
            return 'class="' . implode(' ', $value) . '"';
        }

        if (strpos($name, 'json-data-') === 0) {
            return preg_replace('/^json-/', '', $name) . "='" . $this->attrJsonEncode($value, JSON_UNESCAPED_UNICODE) . "'";
        }

        if (!is_null($value)) {
            return $name . '="' . $this->attrTextValue($value) . '"';
        }
    }

    /**
     * @param array $attrs
     * @return string
     */
    public function attrs($attrs)
    {
        $markup = [];
        foreach ($attrs as $name => $value) {
            $element = $this->attr($name, $value);
            if (!is_null($element)) {
                $markup[] = $element;
            }
        }
        return count($markup) > 0 ? ' ' . implode(' ', $markup) : '';
    }

    /**
     * @param string $name
     * @param * $value
     * @return string
     */
    public function cssRule($propertyName, $propertyValue)
    {
        if (is_numeric($propertyValue) || is_string($propertyValue)) {
            return $propertyName . ':' . $propertyValue;
        }
        return null;
    }

    /**
     * @param array $attrs
     * @return string
     */
    public function cssRules($properties)
    {
        $rules = [];
        foreach ($properties as $name => $value) {
            $rule = $this->cssRule($name, $value);
            if (!is_null($rule)) {
                $rules[] = $rule;
            }
        }
        return count($rules) > 0 ? implode(';', $rules) : '';
    }


    /**
     * @param string $id
     * @param array $attrs
     * @param string $spritemap
     * @return string
     */
    public function svgSymbol($id, $attrs = [], $spritemap = null)
    {
        $svgAttributes = $this->attrs($attrs);
        $useHref = ($spritemap ?: $this->svgSpritemapPath) . '#' . $id;
        return '<svg ' . $svgAttributes . '><use xlink:href="' . $useHref . '"></use></svg>';
    }

    /**
     * @param string $id
     * @param null $number
     * @return string
     */
    protected function getNonRepeatingId ($id, $number = null) {
        $key = $id . ($number ? '-' . $number : '');
        if (isset($this->idCache[$key])) {
            return $this->getNonRepeatingId($id, ($number ? ++$number : 1));
        }
        $this->idCache[$key] = 1;
        return $key;
    }

    /**
     * @param string $id
     * @return string
     */
    public function nonRepeatingId ($id) {
        return $this->getNonRepeatingId($id);
    }

    /**
     * @param string $tag
     * @param array $attrs
     * @return string
     */
    public function htmlOpenTag ($tag, $attrs = []) {
        if (count($attrs)) {
            return '<' . $tag . ' ' . $this->attrs($attrs) . '>';
        }
        return '<' . $tag . '>';
    }

    /**
     * @param string $tag
     * @return string
     */
    public function htmlCloseTag ($tag)
    {
        return '</' . $tag . '>';
    }

    /**
     * @param string $tag
     * @param array $attrs
     * @param array $html
     * @param bool $closeTag
     * @return string
     */
    public function htmlElement ($tag, $attrs = [], $html = [], $closeTag = true) {
        if ($closeTag) {
            return $this->htmlOpenTag($tag, $attrs) . implode(' ', $html) . $this->htmlCloseTag($tag);
        }
        return $this->htmlOpenTag($tag, $attrs);
    }

    /**
     * @param array $attrs
     * @return string
     */
    public function htmlImgElement ($attrs = []) {
        if (!isset($attrs['alt'])) {
            $attrs['alt'] = true;
        }
        return $this->htmlElement('img', $attrs, [], false);
    }

    /**
     * @param array $attrs
     * @return string
     */
    public function htmlAnchorElement($attrs = [], $html = [])
    {
        if (isset($attrs['target']) && $attrs['target'] === '_blank' && !isset($attrs['rel'])) {
            $attrs['rel'] = 'noopener';
        }
        return $this->htmlElement('a', $attrs, $html, true);
    }
}
