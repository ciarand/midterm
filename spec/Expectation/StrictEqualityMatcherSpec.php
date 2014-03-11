<?php

use Ciarand\Midterm\Expectation\StrictEqualityMatcher;

describe("StrictEqualityMatcher", function () {
    it("strictly compares values", function ($actual, $expected) {
        $matcher = new StrictEqualityMatcher($actual);

        expect($matcher->test($expected))->toBe($actual === $expected);
    })->with(
        array("1", "1"),
        array(1, "1"),
        array(1, 1),
        array("two", "two"),
        array("two", 2),
        array("TWO", "two"),
        array("TWO", "TWO"),
        array(array(), array()),
        array((object) array(), array()),
        array((object) array(), (object) array())
    );
});
