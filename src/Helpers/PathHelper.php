<?php 

namespace Jemer\TinyCms\Helpers;

class PathHelper
{
    public static function BuildPath(array $parts) : string
    {
        $str = "";

        foreach ($parts as $part) 
        {
            $str .= $part . DIRECTORY_SEPARATOR;
        }

        return rtrim($str, DIRECTORY_SEPARATOR);
    }
}

?>