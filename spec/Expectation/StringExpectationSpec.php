<?php

use Ciarand\Midterm\Expectation\StringExpectation;

describe("the string expectation", function () {
    it("should pass on a true toContain() call", function ($needle) {
        $callback = callback(function () use ($needle) {
            $expectation = new StringExpectation("foo bar baz");

            $expectation->contain($needle);
        });

        expect($callback)->when()->run()->not()->toThrow();
    })->with(
        array("foo"),
        array("bar"),
        array("baz"),
        array(" ")
    );

    it("should fail on a false toContain() call", function ($needle) {
        $callback = callback(function () use ($needle) {
            $expectation = new StringExpectation("foo bar baz");

            $expectation->contain($needle);
        });

        expect($callback)->when()->run()->toThrow();
    })->with(
        array("foobar"),
        array("barfoo"),
        array("bazzz"),
        array("x")
    );

    it("should pass on a true beginWith() call", function ($needle) {
        $callback = callback(function () use ($needle) {
            $expectation = new StringExpectation("foo bar baz");

            $expectation->beginWith($needle);
        });

        expect($callback)->when()->run()->not()->toThrow();
    })->with(
        array("fo"),
        array("foo"),
        array("foo "),
        array("foo bar"),
        array("foo bar baz")
    );

    it("should fail on a false beginWith() call", function ($needle) {
        $callback = callback(function () use ($needle) {
            $expectation = new StringExpectation("not foo bar baz");

            $expectation->beginWith($needle);
        });

        expect($callback)->when()->run()->toThrow();
    })->with(
        array("fo"),
        array("foo"),
        array("foo "),
        array("foo bar"),
        array("foo bar baz")
    );

    it("should pass on a true endWith() call", function ($needle) {
        $callback = callback(function () use ($needle) {
            $expectation = new StringExpectation("foo bar baz");

            $expectation->endWith($needle);
        });

        expect($callback)->when()->run()->not()->toThrow();
    })->with(
        array("z"),
        array("az"),
        array("baz"),
        array("bar baz"),
        array("foo bar baz")
    );

    it("should fail on a false endWith() call", function ($needle) {
        $callback = callback(function () use ($needle) {
            $expectation = new StringExpectation("foo bar baz not");

            $expectation->endWith($needle);
        });

        expect($callback)->when()->run()->toThrow();
    })->with(
        array("z"),
        array("az"),
        array("baz"),
        array("bar baz"),
        array("foo bar baz")
    );

    it("should pass on a true match() call", function ($pattern) {
        $callback = callback(function () use ($pattern) {
            $expectation = new StringExpectation("foo bar baz");

            $expectation->match($pattern);
        });

        expect($callback)->when()->run()->not()->toThrow();
    })->with(
        array("/^foo/"),
        array("/^foo bar/"),
        array("/baz$/"),
        array("/^foo bar baz$/"),
        array("/^FoO BAR bAz/i")
    );

    it("should fail on a false match() call", function ($pattern) {
        $callback = callback(function () use ($pattern) {
            $expectation = new StringExpectation("foo bar baz");

            $expectation->match($pattern);
        });

        expect($callback)->when()->run()->toThrow();
    })->with(
        array("/foo$/"),
        array("/foo bar$/"),
        array("/^baz/"),
        array("/^foo baz bar$/"),
        array("/^FoO BAR bAz/")
    );
});
