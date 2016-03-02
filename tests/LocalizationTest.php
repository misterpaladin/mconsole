<?php

class LocalizationTest extends TestCase
{
    private static $languages;
    private static $base;
    
    /**
     * Collect languages
     */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        $baseLocale = 'en';
        foreach (glob(__DIR__ . '/../src/resources/lang/*') as $path) {
            $lang = basename($path);
            
            if ($lang != $baseLocale) {
                self::$languages[$lang]['path'] = $path;
            }
            
            foreach (glob($path . '/*.php') as $file) {
                if ($lang == $baseLocale) {
                    self::$base['path'] = $path;
                    self::$base['files'][] = basename($file);
                } else {
                    self::$languages[$lang]['files'][] = basename($file);
                }
            }
        }
    }
    
    /**
     * Check if each language files count equals to base language
     * 
     * @return void
     */
    public function testLocalizationFilesMatch()
    {
        foreach (self::$languages as $lang) {
            $this->assertEquals(count(self::$base['files']), count($lang['files']));
        }
    }
    
    /**
     * Test each language to match file names
     * 
     * @return void
     */
    public function testLocalizationFilesNames()
    {
        foreach (self::$languages as $lang) {
            $this->assertTrue(count(array_diff(self::$base['files'], $lang['files'])) == 0);
        }
    }
    
    /**
     * Test each language array to match base language
     *  
     * @return void
     */
    public function testLocalizationFilesContents()
    {
        $results = [];
        
        // Anonymous recursive function to compare multidimensional arrays
        function m_array_diff_key($a1, $a2, $lKey)
        {
            $result = array_diff_key($a1, $a2);
            if (count($result) > 0) {
                dump(json_encode(array_dot($result)) . ' is not localized to ' . $lKey);
            }
            foreach ($a1 as $key => $base) {
                if (is_array($base)) {
                    if (isset($a2[$key])) {
                        $result[] = m_array_diff_key($a1[$key], $a2[$key], $lKey);
                    }
                }
            }
            
            return $result;
        }
        
        // Collect results
        foreach (self::$languages as $lKey => $lang) {
            foreach ($lang['files'] as $file) {
                $base = include(self::$base['path'] . '/' . $file);
                $localization = include($lang['path'] . '/' . $file);
                $results[$lKey][] = m_array_diff_key($base, $localization, $lKey);
            }
        }
        
        // Assertion
        foreach ($results as $lKey => $lResult) {
            foreach ($lResult as $result) {
                $this->assertTrue(count($result) == 0);
            }
        }
    }
}
