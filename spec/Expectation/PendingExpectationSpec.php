<?php

use Ciarand\Midterm\Expectation\PendingExpectation;
use Ciarand\Midterm\Expectation\CallbackExpectation;

describe("the PendingExpectation", function () {
    it("should create a callback expectation on run()", function () {
        $actual = with(new PendingExpectation("foo"))->run();
        $class = CallbackExpectation::className();

        expect($actual)->to()->be()->anInstanceOf($class);
    });
});
