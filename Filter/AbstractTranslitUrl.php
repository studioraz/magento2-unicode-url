<?php

/**
 * Filter URL keys including UTF-8 characters
 *
 * Logic formatting is based on Wordpress formatting functions.
 * @see: https://github.com/WordPress/WordPress/blob/master/wp-includes/formatting.php
 */

namespace SR\UnicodeUrl\Filter;

class AbstractTranslitUrl implements \Zend_Filter_Interface
{

    public function filter($value)
    {

        return urldecode($this->sanitize($value));
    }

    /**
     *
     * Sanitizes a url key, replacing whitespace and a few other characters with dashes.
     *
     * @param string $value The url key to be sanitized.
     * @return string
     */
    function sanitize($value)
    {
        $urlKey = strip_tags($value);
        // Preserve escaped octets.
        $urlKey = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $urlKey);
        // Remove percent signs that are not part of an octet.
        $urlKey = str_replace('%', '', $urlKey);
        // Restore octets.
        $urlKey = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $urlKey);


        if ($this->seemsUtf8($urlKey)) {
            if (function_exists('mb_strtolower')) {
                $urlKey = mb_strtolower($urlKey, 'UTF-8');
            }
            $urlKey = $this->utf8UriEncode($urlKey);
        }

        $urlKey = strtolower($urlKey);
        $urlKey = preg_replace('/&.+?;/', '', $urlKey); // kill entities
        $urlKey = str_replace('.', '-', $urlKey);
        $urlKey = preg_replace('/[^%a-z0-9 _-]/', '', $urlKey);
        $urlKey = preg_replace('/\s+/', '-', $urlKey);
        $urlKey = preg_replace('|-+|', '-', $urlKey);
        $urlKey = trim($urlKey, '-');

        return $urlKey;
    }

    /**
     * Encode the Unicode values to be used in the URI.
     *
     * @param string $utf8_string
     * @param int $length Max  length of the string
     * @return string String with Unicode encoded for URI.
     */
    function utf8UriEncode($utf8_string, $length = 0)
    {
        $unicode = '';
        $values = array();
        $num_octets = 1;
        $unicode_length = 0;
        $this->mbstringBinarySafeEncoding(false);
        $string_length = strlen($utf8_string);
        $this->mbstringBinarySafeEncoding(true);
        for ($i = 0; $i < $string_length; $i++) {
            $value = ord($utf8_string[$i]);
            if ($value < 128) {
                if ($length && ($unicode_length >= $length))
                    break;
                $unicode .= chr($value);
                $unicode_length++;
            } else {
                if (count($values) == 0) {
                    if ($value < 224) {
                        $num_octets = 2;
                    } elseif ($value < 240) {
                        $num_octets = 3;
                    } else {
                        $num_octets = 4;
                    }
                }
                $values[] = $value;
                if ($length && ($unicode_length + ($num_octets * 3)) > $length)
                    break;
                if (count($values) == $num_octets) {
                    for ($j = 0; $j < $num_octets; $j++) {
                        $unicode .= '%' . dechex($values[$j]);
                    }
                    $unicode_length += $num_octets * 3;
                    $values = array();
                    $num_octets = 1;
                }
            }
        }
        return $unicode;
    }


    /**
     * checks if value encoded in utf8
     *
     * @param string $str
     * @return string
     */
    function seemsUtf8($str)
    {
        $this->mbstringBinarySafeEncoding(false);
        $length = strlen($str);
        $this->mbstringBinarySafeEncoding(true);
        for ($i = 0; $i < $length; $i++) {
            $c = ord($str[$i]);
            if ($c < 0x80) $n = 0; // 0bbbbbbb
            elseif (($c & 0xE0) == 0xC0) $n = 1; // 110bbbbb
            elseif (($c & 0xF0) == 0xE0) $n = 2; // 1110bbbb
            elseif (($c & 0xF8) == 0xF0) $n = 3; // 11110bbb
            elseif (($c & 0xFC) == 0xF8) $n = 4; // 111110bb
            elseif (($c & 0xFE) == 0xFC) $n = 5; // 1111110b
            else return false; // Does not match any model
            for ($j = 0; $j < $n; $j++) { // n bytes matching 10bbbbbb follow ?
                if ((++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80))
                    return false;
            }
        }
        return true;

    }

    function mbstringBinarySafeEncoding($reset)
    {
        static $encodings = array();
        static $overloaded = null;

        if (is_null($overloaded))
            $overloaded = function_exists('mb_internal_encoding') && (ini_get('mbstring.func_overload') & 2);

        if (false === $overloaded)
            return;

        if (!$reset) {
            $encoding = mb_internal_encoding();
            array_push($encodings, $encoding);
            mb_internal_encoding('ISO-8859-1');
        }

        if ($reset && $encodings) {
            $encoding = array_pop($encodings);
            mb_internal_encoding($encoding);
        }
    }


}
