<?php

use Ciarand\Midterm\Config\FileGlobber;

describe("the hero known as the FileGlobber", function () {
    it("should be able to return an iterator", function () {
        $globber = new FileGlobber("**/*Spec.php");

         expect($globber->getIterator())->to()->be()->anInstanceOf("RegexIterator");
    });

    it("should parse globstars as regexes", function ($glob, $regex, $recurse) {
        $iterator = with($globber = new FileGlobber($glob))->getIterator();

        // PHP 5.3 does not offer this method
        if (method_exists($iterator, "getRegex")) {
            expect($iterator->getRegex())->to()->be()->a($regex);
        }

        expect($globber->isRecursive())->to()->be()->a($recurse);
    })->with(
        array("**/*Spec.php", '/^(.+)?Spec\.php$/', true),
        array("../**/*Spec.php", '/^(.+)?Spec\.php$/', true),
        array("../*Spec*.php", '/^(.+)?Spec(.+)?\.php$/', false),
        array("../**/Spec*.php", '/^Spec(.+)?\.php$/', true),
        array("*Spec*.php", '/^(.+)?Spec(.+)?\.php$/', false)
    );
});
