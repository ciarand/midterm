<?php

use Ciarand\Midterm\Spec;
use Ciarand\Midterm\SpecRunner;
use Ciarand\Midterm\SuiteHelper;
use Ciarand\Midterm\Exception\SpecFailedException;
use Ciarand\Midterm\Exception\SpecSkippedException;

describe("Spec", function ($vars) {
    it("should return a pass result on a passing test", function () {
        $test = new Spec("foo", function () {
            // Do nothing
        });

        $suiteHelper = new SuiteHelper;

        $result = $test->runWithData(array(), $suiteHelper);
        expect($result->didFail())->toBe(false);
        expect($result->didSkip())->toBe(false);
        expect($result->didPass())->toBe(true);
    });

    it("should return a fail result on a failing test", function () {
        $test = new Spec("foo", function () {
            throw new Exception("fail");
        });

        $suiteHelper = new SuiteHelper;

        $result = $test->runWithData(array(), $suiteHelper);
        expect($result->didFail())->toBe(true);
        expect($result->didSkip())->toBe(false);
        expect($result->didPass())->toBe(false);
    });

    it("should return a skip result on a skipped test", function () {
        $test = new Spec("foo", function ($helper) {
            $helper->skip();
        });

        $suiteHelper = new SuiteHelper;

        $result = $test->runWithData(array(), $suiteHelper);
        expect($result->didFail())->toBe(false);
        expect($result->didSkip())->toBe(true);
        expect($result->didPass())->toBe(false);
    });

    it("should be able to fail a test with message", function ($spec) {
        $test = new Spec("foo", function () {
            // do nothing
        });

        try {
            $test->fail("foobar");

            $spec->fail("Exception was not thrown");
        } catch (SpecFailedException $e) {
            expect($e->getMessage())->toBe("foobar");
        }
    });

    it("should be able to skip a test with message", function ($spec) {
        $test = new Spec("foo", function () {
            // do nothing
        });

        try {
            $test->skip("foobar");

            $spec->fail("Exception was not thrown");
        } catch (SpecSkippedException $e) {
            expect($e->getMessage())->toBe("foobar");
        };
    });

    it("should not have a message on pass", function ($spec) {
        $test = new Spec("foo", function () {
            // do nothing
        });

        $result = $test->runWithData(array(), new SuiteHelper);

        expect($result->getMessage())->toBe(null);
    });

    it("should run multiple times when `with` is called", function ($spec) {
        $count = 0;

        $test = new Spec("foo", function () use (&$count) {
            $count += 1;
        });

        $runner = new SpecRunner($test);

        $runner->with(array("foo"), array("bar"));

        $runner->run(new SuiteHelper);

        expect($count)->toBe(2);
    });
});
