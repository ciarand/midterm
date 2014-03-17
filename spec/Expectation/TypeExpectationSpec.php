<?php

use Ciarand\Midterm\Expectation\TypeExpectation;
use Ciarand\Midterm\Expectation\StringExpectation;

describe("the type expectation", function () {
    it("returns a StringExpectation on string() call", function () {
        $actual = with(new TypeExpectation("foo"))->string();
        $class = StringExpectation::className();

        expect($actual)->to()->be()->anInstanceOf($class);
    });
});
