<?php

use Ciarand\Midterm\Reporter\DotReporter;
use Ciarand\Midterm\Result\SpecResult;
use Prophecy\Prophet;

describe("DotReporter", function () {
    it("prints an F for a failing test", function () {
        $prophet = new Prophet;
        $failure = $prophet->prophesize(SpecResult::className());
        $failure->didFail()->willReturn(true);
        $failure->getMessage()->willReturn("foo was not bar");
        $failure->title = "test title";

        $reporter = new DotReporter;

        expect(function () use ($reporter, $failure) {
            $reporter->onSpecFail($failure->reveal());
        })->when()->run()->toOutput("F");
    });

    it("prints a . for a passing test", function () {
        $callback = callback(function () {
            $reporter = new DotReporter;
            $prophet = new Prophet;
            $success = $prophet->prophesize(SpecResult::className());
            $success->didFail()->willReturn(false);

            $reporter->onSpecPass($success->reveal());
        });

        expect($callback)->when()->run()->toOutput(".");
    });

    it("prints the time taken in a test run", function () {
        $callback = callback(function () {
            $reporter = new DotReporter;
            $reporter->onTestBegin();
            $reporter->onTestEnd();
        });

        expect($callback)->when()->run()
            ->output()->match('/^Time: (\-)?\d+(\.\d{1,2})?.*/m');
    });

    it("prints the memory taken in a test run", function () {
        $callback = callback(function () {
            $reporter = new DotReporter;
            $reporter->onTestEnd();
        });

        expect($callback)->when()->run()
            ->output()->match('/Memory: ([0-9]+\.[0-9]+)*/m');
    });

    it("prints OK when no tests failed", function () {
        $callback = callback(function () {
            $prophet = new Prophet;
            $success = $prophet->prophesize(SpecResult::className());
            $success->didFail()->willReturn(false);
            $reporter = new DotReporter;

            for ($i = 0; $i < 3; $i += 1) {
                $reporter->onUpdate($success->reveal());
            }
            $reporter->onTestEnd();
        });

        expect($callback)->when()->run()->output()->match("/^OK/m");
    });

    it("prints FAILURES! when a test fails", function () {
        $callback = callback(function () {
            $prophet = new Prophet;
            $failure = $prophet->prophesize(SpecResult::className());
            $failure->didFail()->willReturn(true);
            $failure->getMessage()->willReturn("foo was not bar");
            $failure->title = "test title";
            $reporter = new DotReporter;
            $reporter->onUpdate($failure->reveal());

            $reporter->onTestEnd();
        });

        expect($callback)->when()->run()->output()->match("/^FAILURES!/m");
    });

    it("prints the number of tests with 0 fails", function () {
        $callback = callback(function () {
            $prophet = new Prophet;
            $success = $prophet->prophesize(SpecResult::className());
            $success->didFail()->willReturn(false);
            $reporter = new DotReporter;

            for ($i = 0; $i < 3; $i += 1) {
                $reporter->onUpdate($success->reveal());
            }

            $reporter->onTestEnd();
        });

        expect($callback)->when()->run()->output()->match("/\(3 tests\)/");
    });

    it("prints # of tests w/ >0 fails", function () {
        $prophet = new Prophet;
        $failure = $prophet->prophesize(SpecResult::className());
        $failure->didFail()->willReturn(true);
        $failure->getMessage()->willReturn("foo was not bar");
        $failure->title = "test title";
        $success = $prophet->prophesize(SpecResult::className());
        $success->didFail()->willReturn(false);
        $reporter = new DotReporter;

        $reporter->onUpdate($failure->reveal());

        for ($i = 0; $i < 3; $i += 1) {
            $reporter->onUpdate($success->reveal());
        }

        expect(array($reporter, "onTestEnd"))->when()->run()
            ->output()->match("/Failures: 1/");
    });

    it("prints the failed spec names", function () {
        $prophet = new Prophet;
        $failure = $prophet->prophesize(SpecResult::className());
        $failure->didFail()->willReturn(true);
        $failure->getMessage()->willReturn("foo was not bar");
        $failure->title = "test title";
        $reporter = new DotReporter;

        $reporter->onUpdate($failure->reveal());

        expect(array($reporter, "onTestEnd"))->when()->run()
            ->output()->match("/^1\) test title: foo was not bar$/m");
    });
});
