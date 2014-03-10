<?php

use Ciarand\Midterm\Expectation\StrictEqualityMatcher;

describe("StrictEqualityMatcher", function () {
    $comparisons = array(
        array("1", "1"),
        array(1, "1"),
        array(1, 1),
        array("two", "two"),
        array("two", 2),
        array("TWO", "two"),
        array("TWO", "TWO"),
        array(array(), array()),
        array((object) array(), array()),
        array((object) array(), (object) array()),
    );

    foreach ($comparisons as $comparison) {
        it("strictly compares values", function () use ($comparison) {
            list($actual, $expected) = $comparison;

            $matcher = new StrictEqualityMatcher($actual);

            expect($matcher->test($expected))->toBe($actual === $expected);
        });

        it("creates a helpful error message", function () use ($comparison) {
            list($actual, $expected) = $comparison;

            $matcher = new StrictEqualityMatcher($actual);
            $matcher->test($expected);

            expect($matcher->getMessage())
                ->toMatch("/^Expected (.+) to be (.+)/ms");
        });
    }
});
