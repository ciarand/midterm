<?php

use Ciarand\Midterm\Expectation\IdentityExpectation;

describe("the IdentityExpectation", function () {
    it("should match on instanceof", function () {
        $expectation = new IdentityExpectation((object) array());
    });

    it("should fail on a false check for true()", function () {
        $expectation = new IdentityExpectation(false);

        expect(array($expectation, "true"))->when()->run()->toThrow();
    });

    it("should pass on a true check for true()", function () {
        $expectation = new IdentityExpectation(true);

        expect(array($expectation, "true"))->when()->run()->not()->toThrow();
    });

    it("should pass on a false check for false()", function () {
        $expectation = new IdentityExpectation(false);

        expect(array($expectation, "false"))->when()->run()->not()->toThrow();
    });

    it("should fail on a true check for false()", function () {
        $expectation = new IdentityExpectation(true);

        expect(array($expectation, "false"))->when()->run()->toThrow();
    });

    it("should pass on a null check for null()", function () {
        $expectation = new IdentityExpectation(null);

        expect(array($expectation, "null"))->when()->run()->not()->toThrow();
    });

    it("should fail on a false check for null()", function () {
        $expectation = new IdentityExpectation(false);

        expect(array($expectation, "null"))->when()->run()->toThrow();
    });

    it("should fail on a true check for null()", function () {
        $expectation = new IdentityExpectation(true);

        expect(array($expectation, "null"))->when()->run()->toThrow();
    });

    it("should pass on a true loose equality check", function () {
        $expectation = new IdentityExpectation("1");

        $callback = callback(function () use ($expectation) {
            $expectation->equalTo(1);
        });

        expect($callback)->when()->run()->not()->toThrow();
    });

    it("should fail on a false loose equality check", function () {
        $expectation = new IdentityExpectation("1");

        $callback = callback(function () use ($expectation) {
            $expectation->equalTo(2);
        });

        expect($callback)->when()->run()->toThrow();
    });

    it("should pass on a true greaterThan check", function () {
        $expectation = new IdentityExpectation("1");

        $callback = callback(function () use ($expectation) {
            $expectation->greaterThan(0);
        });

        expect($callback)->when()->run()->not()->toThrow();
    });

    it("should fail on a false greaterThan check", function () {
        $expectation = new IdentityExpectation("1");

        $callback = callback(function () use ($expectation) {
            $expectation->greaterThan(2);
        });

        expect($callback)->when()->run()->toThrow();
    });

    it("should pass on a true lessThan check", function () {
        $expectation = new IdentityExpectation("1");

        $callback = callback(function () use ($expectation) {
            $expectation->lessThan(2);
        });

        expect($callback)->when()->run()->not()->toThrow();
    });

    it("should fail on a false lessThan check", function () {
        $expectation = new IdentityExpectation("1");

        $callback = callback(function () use ($expectation) {
            $expectation->lessThan(0);
        });

        expect($callback)->when()->run()->toThrow();
    });

    it("should pass on a true withinRange check", function () {
        $expectation = new IdentityExpectation("1");

        $callback = callback(function () use ($expectation) {
            $expectation->withinRange(0, 2);
        });

        expect($callback)->when()->run()->not()->toThrow();
    });

    it("should fail on a false withinRange check", function () {
        $expectation = new IdentityExpectation("1");

        $callback = callback(function () use ($expectation) {
            $expectation->withinRange(2, 3);
        });

        expect($callback)->when()->run()->toThrow();
    });

    it("should pass on a true `a()` check", function ($actual, $expected) {
        $expectation = new IdentityExpectation($actual);

        $callback = callback(function () use ($expectation, $expected) {
            $expectation->a($expected);
        });

        expect($callback)->when()->run()->not()->toThrow();
    })->with(
        array(1, 1),
        array("1", "1"),
        array(true, true)
    );

    it("should fail on a false `a()` check", function ($actual, $expected) {
        $expectation = new IdentityExpectation($actual);

        $callback = callback(function () use ($expectation, $expected) {
            $expectation->a($expected);
        });

        expect($callback)->when()->run()->toThrow();
    })->with(
        array(1, "1"),
        array(true, 1),
        array(null, false)
    );
});
