<?php

/**
 * Remove random suffix from string in format 'file-name-suffix.ext'
 * Gives file-name.ext
 *
 * @param string $filename [File name]
 * @return string [Original file name]
 */
if (!function_exists('file_get_original_name')) {
    function file_get_original_name($filename)
    {
        $errname = [];
        $errname['original'] = $filename;
        $errname['extension'] = pathinfo($errname['original'], PATHINFO_EXTENSION);
        $errname['exploded'] = explode('-', $errname['original']);
        array_pop($errname['exploded']);
        $errname['final'] = implode('-', $errname['exploded']);
        return sprintf('%s.%s', $errname['final'], $errname['extension']);
    }
}

/**
 * Remove parenthesis from string
 *
 * @param string $text [Text]
 * @return string [Processed text]
 */
if (!function_exists('str_remove_parenthesis')) {
    function str_remove_parenthesis($text)
    {
        return str_replace(['(', ')'], null, $text);
    }
}

/**
 * Remove quotes from string
 *
 * @param string $text [Text]
 * @return string [Processed text]
 */
if (!function_exists('str_remove_quotes')) {
    function str_remove_quotes($text)
    {
        return str_replace(['\''], null, $text);
    }
}

/**
 * Remove double quotes from string
 *
 * @param string $text [Text]
 * @return string [Processed text]
 */
if (!function_exists('str_remove_double_quotes')) {
    function str_remove_double_quotes($text)
    {
        return str_replace(['""'], null, $text);
    }
}

/**
 * Make given url absolute with mconsole base url
 *
 * @param  string $url  [Relative url]
 * @param  bool   $trim [Trim slashes]
 * @return string [Absolute url]
 */
if (!function_exists('mconsole_url')) {
    function mconsole_url($url = null, $trim = false)
    {
        $base = config('mconsole.url');
        
        if (!is_null($url)) {
            $url = trim($url, '/');
            
            if (\Illuminate\Support\Str::startsWith($url, 'mconsole')) {
                str_replace('mconsole', $url);
            }
            
            $url = trim($url, '/');
        }
        
        if ($base == '/') {
            $result = sprintf('/%s', $url);
        } else {
            $base = trim($base, '/');
            if (strlen($url) > 0) {
                $url = '/' . $url;
            }
            $result = sprintf('/%s%s', $base, $url);
        }
        
        return $trim ? trim($result, '/') : $result;
    }
}
