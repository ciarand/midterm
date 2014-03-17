<?php

use Ciarand\Midterm\Spec\Permutation;

describe("A test permutation", function () {
    it("should have a title", function () {
        $perm = with(new Permutation("foo"))->title("title");

        expect($perm->getTitle())->to()->be()->a("title");
    });

    it("should be able to return arguments", function () {
        $perm = new Permutation(array("foo"));

        expect($perm->getArgs())->to()->be()->an(array("foo"));
    });

    it("should have an alias, 'data'", function () {
        $perm = data("arg1", array("nested arg2"));

        expect($perm)->to()->be()->anInstanceOf(Permutation::className());
    });
});
