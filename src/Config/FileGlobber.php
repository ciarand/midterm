<?php namespace Ciarand\Midterm\Config;

use DirectoryIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;
use Ciarand\Midterm\BaseComponent;

class FileGlobber extends BaseComponent
{
    public function __construct($pattern)
    {
        $this->pattern = $pattern;
    }

    public function getIterator()
    {
        $info = $this->globInfo();

        $directory = $info["regex"]
            ? new RecursiveDirectoryIterator($info["dirname"])
            : new DirectoryIterator($info["dirname"]);

        return new RegexIterator(
            new RecursiveIteratorIterator($directory),
            $info["regex"],
            RecursiveRegexIterator::GET_MATCH
        );
    }

    public function isRecursive()
    {
        $info = $this->globInfo();

        return $info["recursive"];
    }

    protected function globInfo()
    {
        // We need to get:
        // a. starting dir
        //      will either be . or specified
        // b. a regex representing the filename
        //      if the * is followed by, like, a *.php
        //      if the * is preceeded by, like, a Test*
        // c. whether it's recursive or not
        //      check presense of **

        $recursive = false;

        $pathinfo = pathinfo($this->pattern);

        $dirname = $pathinfo["dirname"];

        $pos = strpos($dirname, "**");
        if ($pos !== false) {
            $recursive = true;
            $dirname = substr($dirname, 0, $pos);
        }

        $dirname = $dirname ?: ".";

        $regex = sprintf(
            "/^%s$/",
            str_replace(
                array(".", "*"),
                array("\\.", "(.+)?"),
                $pathinfo["basename"]
            )
        );

        return array(
            "dirname" => $dirname,
            "regex" => $regex,
            "recursive" => $recursive,
        );
    }
}
