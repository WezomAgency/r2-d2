<?php

namespace WezomAgency;

/**
 * Class R2D2
 * @package WezomAgency
 */
class R2D2
{
    private static $instance = null;

    /**
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
     * @param string $key
     * @param string $value
     * @return R2D2 $this
     * @throws \Exception
     */
    public function set($key, $value)
    {
        if (property_exists($this, $key) === false) {
            if ($this->debug) {
                throw new \Exception("Property $key does not exist in class " . __CLASS__);
            } else {
                return $this;
            }
        }
        switch ($key) {
            case 'rootPath':
            case 'resourceRelativePath':
                $this->$key = rtrim($value, '/') . '/';
                break;
            default:
                $this->$key = $value;
        }

        return $this;
    }


    /**
     * @param string $url
     * @param boolean $timestamp
     * @param boolean $absolute
     * @return string
     */
    public function fileUrl($url, $timestamp = false, $absolute = false)
    {

        $root = $absolutePath ? ($this->protocol . $this->host) : '/';
        $file = trim($url, '/');
        if ($timestamp) {
            if ($this->fileUrlTimestampsCache[$file] === null && is_file($this->rootPath . $file)) {
                $this->fileUrlTimestampsCache[$file] = '?time=' . fileatime($this->rootPath . $file);
            }
            return $root . $file . $this->fileUrlTimestampsCache[$file];
        }
        return $root . $file;
    }

    /**
     * @param string $path
     * @return bool|string
     */
    public function fileContent($path)
    {
        $path = $this->fileUrl($path, false, false);
        return file_get_contents($this->rootPath . $path);
    }


    /**
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
     * @param string $path
     * @return bool|string
     */
    public function resourceContent($path)
    {
        return $this->fileContent($this->resourceRelativePath . ltrim($path, '/'));
    }


    /**
     * @param string $value
     * @param bool $int
     * @return int|float
     */
    public function str2number($value = '', $int = false)
    {
        if (strpos($value, '%')) {
            return 0;
        }
        return $int ? intval($value) : floatval($value);
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
            return preg_replace('/^json-/', '', $name) . "='" . json_encode($value, JSON_UNESCAPED_UNICODE) . "'";
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
        if ($this->idCache[$key] === null) {
            $this->idCache[$key] = 1;
            return $key;
        }
        return $this->getNonRepeatingId($id, ($number ? ++$number : 1));
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
        if (!$attrs['alt']) {
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
        if ($attrs['target'] === '_blank' && !$attrs['rel']) {
            $attrs['rel'] = 'noopener';
        }
        return $this->htmlElement('a', $attrs, $html, true);
    }
}
