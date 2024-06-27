<?php
class YAMLParser {
    public static function parse($file) {
        $contents = file_get_contents($file);
        $lines = explode("\n", $contents);
        $config = [];

        foreach ($lines as $line) {
            // Skip empty lines and comments
            if (trim($line) == '' || strpos(trim($line), '#') === 0) {
                continue;
            }

            // Split key and value at the first colon
            $parts = explode(':', $line, 2);
            $key = trim($parts[0]);
            $value = trim($parts[1]);

            // Parse value if it's a quoted string
            if (strpos($value, '"') === 0 || strpos($value, "'") === 0) {
                $value = trim($value, '"\'');
            }

            // Set nested values using dot notation
            $config = self::setValue($config, $key, $value);
        }

        return $config;
    }

    private static function setValue(&$array, $keys, $value) {
        $keys = explode('.', $keys);
        $ref = &$array;

        foreach ($keys as $key) {
            if (!isset($ref[$key])) {
                $ref[$key] = [];
            }
            $ref = &$ref[$key];
        }
        $ref = $value;
        return $array;
    }
}
?>