<?php

use Ciarand\Midterm\Expectation\InstanceOfMatcher;

describe("InstanceOfMatcher", function () {
    it("should be the same as instanceof", function ($instance, $class) {
        $matcher = new InstanceOfMatcher($class);

        expect($matcher->test($instance))->toBe($instance instanceof $class);
    })->with(
        array((object) array("foo" => "bar"), "stdClass"),
        array((object) array("foo" => "bar"), "FooClass")
    );
});
