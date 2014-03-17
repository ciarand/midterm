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
        data("foo"),
        data("bar"),
        data("baz"),
        data(" ")
    );

    it("should fail on a false toContain() call", function ($needle) {
        $callback = callback(function () use ($needle) {
            $expectation = new StringExpectation("foo bar baz");

            $expectation->contain($needle);
        });

        expect($callback)->when()->run()->toThrow();
    })->with(
        data("foobar"),
        data("barfoo"),
        data("bazzz"),
        data("x")
    );

    it("should pass on a true beginWith() call", function ($needle) {
        $callback = callback(function () use ($needle) {
            $expectation = new StringExpectation("foo bar baz");

            $expectation->beginWith($needle);
        });

        expect($callback)->when()->run()->not()->toThrow();
    })->with(
        data("fo"),
        data("foo"),
        data("foo "),
        data("foo bar"),
        data("foo bar baz")
    );

    it("should fail on a false beginWith() call", function ($needle) {
        $callback = callback(function () use ($needle) {
            $expectation = new StringExpectation("not foo bar baz");

            $expectation->beginWith($needle);
        });

        expect($callback)->when()->run()->toThrow();
    })->with(
        data("fo"),
        data("foo"),
        data("foo "),
        data("foo bar"),
        data("foo bar baz")
    );

    it("should pass on a true endWith() call", function ($needle) {
        $callback = callback(function () use ($needle) {
            $expectation = new StringExpectation("foo bar baz");

            $expectation->endWith($needle);
        });

        expect($callback)->when()->run()->not()->toThrow();
    })->with(
        data("z"),
        data("az"),
        data("baz"),
        data("bar baz"),
        data("foo bar baz")
    );

    it("should fail on a false endWith() call", function ($needle) {
        $callback = callback(function () use ($needle) {
            $expectation = new StringExpectation("foo bar baz not");

            $expectation->endWith($needle);
        });

        expect($callback)->when()->run()->toThrow();
    })->with(
        data("z"),
        data("az"),
        data("baz"),
        data("bar baz"),
        data("foo bar baz")
    );

    it("should pass on a true match() call", function ($pattern) {
        $callback = callback(function () use ($pattern) {
            $expectation = new StringExpectation("foo bar baz");

            $expectation->match($pattern);
        });

        expect($callback)->when()->run()->not()->toThrow();
    })->with(
        data("/^foo/"),
        data("/^foo bar/"),
        data("/baz$/"),
        data("/^foo bar baz$/"),
        data("/^FoO BAR bAz/i")
    );

    it("should fail on a false match() call", function ($pattern) {
        $callback = callback(function () use ($pattern) {
            $expectation = new StringExpectation("foo bar baz");

            $expectation->match($pattern);
        });

        expect($callback)->when()->run()->toThrow();
    })->with(
        data("/foo$/"),
        data("/foo bar$/"),
        data("/^baz/"),
        data("/^foo baz bar$/"),
        data("/^FoO BAR bAz/")
    );
});
