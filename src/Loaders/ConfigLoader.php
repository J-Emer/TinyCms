<?php 

namespace Jemer\TinyCms\Loaders;

use Jemer\TinyCms\Helpers\PathHelper;
use Symfony\Component\Yaml\Yaml;

class ConfigLoader
{
    private static ?array $config = null;

    public static function Load(): void
    {
        $filePath = CONFIG;

        if (!file_exists($filePath)) {
            throw new \Exception("Config file not found: {$filePath}");
        }

        self::$config = Yaml::parseFile($filePath);

        if (!is_array(self::$config)) {
            throw new \Exception("Invalid YAML config format in {$filePath}");
        }
    }

    public static function Get(string $key, mixed $default = null): mixed
    {
        if (self::$config === null) {
            self::Load();
        }

        $segments = explode('.', $key);
        $value = self::$config;

        foreach ($segments as $segment) {
            if (!is_array($value) || !array_key_exists($segment, $value)) {
                return $default;
            }
            $value = $value[$segment];
        }

        return $value;
    }
}

?>