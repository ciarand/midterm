<?php

use Ciarand\Midterm\Expectation\CallbackExpectation;
use Ciarand\Midterm\Expectation\StringExpectation;
use Ciarand\Midterm\Exception\SpecFailedException;

describe("the callback expectation", function () {
    it("should run the callback after toThrow()", function () {
        $didRun = false;

        $callback = function () use (&$didRun) {
            $didRun = true;
            throw new Exception;
        };

        with(new CallbackExpectation($callback))->toThrow();

        expect($didRun)->to()->be()->true();
    });

    it("should handle thrown exceptions", function () {
        $exception = new Exception("foobar");
        $callback = function () use ($exception) {
            throw $exception;
        };

        $expectation = new CallbackExpectation($callback);

        // If it doesn't catch it, it'll fail the spec
        $expectation->toThrow($exception);
    });

    it("should fail if the expected exception is not thrown", function ($spec) {
        $exception = new Exception("foobar");
        $callback = function () {
        };

        $expectation = new CallbackExpectation($callback);
        $didFail = false;

        try {
            $expectation->toThrow($exception);
            $didFail = true;
        } catch (Exception $e) {
            return;
        }

        if ($didFail) {
            throw new SpecFailedException("failed");
        }
    });

    it("should fail if the wrong exception was thrown", function ($spec) {
        $exception = new SpecFailedException("foo");
        $callback = function () {
            throw new Exception("bar");
        };

        $expectation = new CallbackExpectation($callback);

        $didFail = false;
        try {
            $expectation->toThrow($exception);

            $didFail = true;
        } catch (Exception $e) {
            return;
        }

        if ($didFail) {
            throw new SpecFailedException("failed");
        }
    });

    it("should check output on toOutput()", function () {
        $expectation = callback(function () {
            $expect = new CallbackExpectation(function () {
                echo "foobar";
            });

            $expect->toOutput("foobar");
        });

        expect($expectation)->when()->run()->not()->toThrow();
    });

    it("should fail on toOutput() with bad output", function ($output) {
        $expectation = callback(function () use ($output) {
            $expect = new CallbackExpectation(function () use ($output) {
                echo $output;
            });

            $expect->toOutput("foobar");
        });

        expect($expectation)->when()->run()->toThrow();
    })->with(
        array("foo"),
        array("barfoo"),
        array("bar"),
        array("baz"),
        array("foobaz"),
        array("barbaz")
    );

    it("should return a StringExpectation from output()", function () {
        $class = StringExpectation::className();

        $callback = callback(function () {
            $expect = new CallbackExpectation(function () {
                echo "hello";
            });

            return $expect->output();
        });

        expect($callback())->to()->be()->anInstanceOf($class);
    });
});
