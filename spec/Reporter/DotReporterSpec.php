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

    $vars->inject(get_defined_vars());

    it("prints an F for a failing test", function ($params) {
        extract($params->export());
        $reporter = clone $baseReporter;

        expect(function () use ($reporter, $failure) {
            $reporter->onSpecFail($failure->reveal());
        })->output()->toBe("F");
    });

    it("prints a . for a passing test", function ($params) {
        extract($params->export());
        $reporter = clone $baseReporter;

        expect(function () use ($reporter, $success) {
            $reporter->onSpecPass($success->reveal());
        })->output()->toBe(".");
    });

    it("prints the time taken in a test run", function ($params) {
        extract($params->export());
        $reporter = clone $baseReporter;

        // Start the clock
        $reporter->onTestBegin();

        expect(function () use ($reporter) {
            $reporter->onTestEnd();
        })->output()->toMatch('/^Time: (\-)?\d+(\.\d{1,2})?.*/m');
    });

    it("prints the memory taken in a test run", function ($params) {
        extract($params->export());
        $reporter = clone $baseReporter;

        expect(function () use ($reporter) {
            $reporter->onTestEnd();
        })->output()->toMatch('/Memory: ([0-9]+\.[0-9]+)*/m');
    });

    it("prints OK when no tests failed", function ($params) {
        extract($params->export());
        $reporter = clone $baseReporter;

        for ($i = 0; $i < 3; $i += 1) {
            $reporter->onUpdate($success->reveal());
        }

        expect(function () use ($reporter) {
            $reporter->onTestEnd();
        })->output()->toMatch("/^OK/m");
    });

    it("prints FAILURES! when at least one test failed", function ($params) {
        extract($params->export());
        $reporter = clone $baseReporter;

        $reporter->onUpdate($failure->reveal());
        expect(array($reporter, "onTestEnd"))->output()->toMatch("/^FAILURES!/m");
    });

    it("prints the number of tests with no failures", function ($params) {
        extract($params->export());
        $reporter = clone $baseReporter;

        for ($i = 0; $i < 3; $i += 1) {
            $reporter->onUpdate($success->reveal());
        }

        expect(array($reporter, "onTestEnd"))->output()->toMatch("/\(3 tests\)/");
    });

    it("prints the number of tests with some failures", function ($params) {
        extract($params->export());
        $reporter = clone $baseReporter;

        $reporter->onUpdate($failure->reveal());

        for ($i = 0; $i < 3; $i += 1) {
            $reporter->onUpdate($success->reveal());
        }

        expect(array($reporter, "onTestEnd"))->output()->toMatch("/Failures: 1/");
    });

    it("prints the failed spec names", function ($params) {
        extract($params->export());
        $reporter = clone $baseReporter;

        $reporter->onUpdate($failure->reveal());

        expect(array($reporter, "onTestEnd"))
            ->output()->toMatch("/^1\) test title: foo was not bar$/m");
    });
});
