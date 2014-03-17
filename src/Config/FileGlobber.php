<?php namespace Ciarand\Midterm\Config;

use DirectoryIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;
use Ciarand\Midterm\BaseComponent;

class FileGlobber extends BaseComponent
{
    // Cache the results so we don't reparse every time
    protected $info;

    public function __construct($pattern)
    {
        $this->pattern = $pattern;

        $this->info = $this->globInfo();
    }

    public function getIterator()
    {
        $directory = $this->info["regex"]
            ? new RecursiveDirectoryIterator($this->info["dirname"])
            : new DirectoryIterator($this->info["dirname"]);

        return new RegexIterator(
            new RecursiveIteratorIterator($directory),
            $this->info["regex"],
            RecursiveRegexIterator::GET_MATCH
        );
    }

    public function isRecursive()
    {
        return $this->info["recursive"];
    }

    // Get the info regarding the glob. Similar to pathinfo, but with the
    // following fields:
    //      dirname => the name of the directory, with all stars removed
    //      regex => the regex to match for files on
    //      recursive => whether to follow directories recursively
    protected function globInfo()
    {
        $pathinfo = pathinfo($this->pattern);

        $pos = strpos($pathinfo["dirname"], "**");

        $dirname = $pos !== false
            ? (substr($pathinfo["dirname"], 0, $pos) ?: ".")
            : $pathinfo["dirname"];

        $recursive = $pos !== false;

        $regex = $this->convertGlobToRegex($pathinfo["basename"]);

        return array(
            "dirname" => $dirname,
            "regex" => $regex,
            "recursive" => $recursive,
        );
    }

    protected function convertGlobToRegex($glob)
    {
        return sprintf(
            "/^%s$/",
            str_replace(array(".", "*"), array("\\.", "(.+)?"), $glob)
        );
    }
}
