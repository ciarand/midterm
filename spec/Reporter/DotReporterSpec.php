<?php

use Ciarand\Midterm\Reporter\DotReporter;
use Ciarand\Midterm\Result\SpecResult;
use Prophecy\Prophet;

describe("DotReporter", function ($vars) {
    $baseReporter = new DotReporter;
    $prophet = $prophet = new Prophet;

    $success = $prophet->prophesize(SpecResult::className());
    $success->didFail()->willReturn(false);

    $failure = $prophet->prophesize(SpecResult::className());
    $failure->didFail()->willReturn(true);
    $failure->getMessage()->willReturn("foo was not bar");
    $failure->title = "test title";

    it(
        "prints an F for a failing test",
        function () use ($baseReporter, $failure) {
            $reporter = clone $baseReporter;

            expect(function () use ($reporter, $failure) {
                $reporter->onSpecFail($failure->reveal());
            })->when()->run()->toOutput("F");
        }
    );

    it(
        "prints a . for a passing test",
        function () use ($baseReporter, $success) {
            $reporter = clone $baseReporter;

            expect(function () use ($reporter, $success) {
                $reporter->onSpecPass($success->reveal());
            })->when()->run()->toOutput(".");
        }
    );

    it("prints the time taken in a test run", function () use ($baseReporter) {
        $callback = callback(function () use ($baseReporter) {
            $reporter = clone $baseReporter;
            $reporter->onTestBegin();
            $reporter->onTestEnd();
        });

        expect($callback)->when()->run()
            ->output()->match('/^Time: (\-)?\d+(\.\d{1,2})?.*/m');
    });

    it("prints the memory taken in a test run", function () use ($baseReporter) {
        $callback = callback(function () use ($baseReporter) {
            $reporter = clone $baseReporter;
            $reporter->onTestEnd();
        });

        expect($callback)->when()->run()
            ->output()->match('/Memory: ([0-9]+\.[0-9]+)*/m');
    });

    it(
        "prints OK when no tests failed",
        function () use ($baseReporter, $success) {
            $callback = callback(function () use ($baseReporter, $success) {
                $reporter = clone $baseReporter;

                for ($i = 0; $i < 3; $i += 1) {
                    $reporter->onUpdate($success->reveal());
                }
                $reporter->onTestEnd();
            });

            expect($callback)->when()->run()->output()->match("/^OK/m");
        }
    );

    it(
        "prints FAILURES! when at least one test failed",
        function () use ($baseReporter, $failure) {
            $callback = callback(function () use ($baseReporter, $failure) {
                $reporter = clone $baseReporter;
                $reporter->onUpdate($failure->reveal());

                $reporter->onTestEnd();
            });

            expect($callback)->when()->run()->output()->match("/^FAILURES!/m");
        }
    );

    it(
        "prints the number of tests with no failures",
        function () use ($baseReporter, $success) {
            $callback = callback(function () use ($baseReporter, $success) {
                $reporter = clone $baseReporter;

                for ($i = 0; $i < 3; $i += 1) {
                    $reporter->onUpdate($success->reveal());
                }

                $reporter->onTestEnd();
            });

            expect($callback)->when()->run()->output()->match("/\(3 tests\)/");
        }
    );

    it(
        "prints the number of tests with some failures",
        function () use ($baseReporter, $failure, $success) {
            $reporter = clone $baseReporter;

            $reporter->onUpdate($failure->reveal());

            for ($i = 0; $i < 3; $i += 1) {
                $reporter->onUpdate($success->reveal());
            }

            expect(array($reporter, "onTestEnd"))->when()->run()
                ->output()->match("/Failures: 1/");
        }
    );

    it(
        "prints the failed spec names",
        function () use ($baseReporter, $failure) {
            $reporter = clone $baseReporter;

            $reporter->onUpdate($failure->reveal());

            expect(array($reporter, "onTestEnd"))->when()->run()
                ->output()->match("/^1\) test title: foo was not bar$/m");
        }
    );
});
