<?php

use Ciarand\Midterm\Reporter\TapReporter;
use Ciarand\Midterm\Result\SpecResult;
use Ciarand\Midterm\Result\TestResult;
use Ciarand\Midterm\Suite;
use Prophecy\Prophet;
use Prophecy\Argument;

describe("TapReporter", function ($vars) {
    $beforeEach = function () use ($vars) {
        $prophet  = new Prophet;
        $reporter = new TapReporter;
        $result   = $prophet->prophesize(TestResult::className());

        $result->on(Argument::cetera())->willReturn(null);

        return get_defined_vars();
    };

    $vars->inject(get_defined_vars());

    it("identifies itself as TAP13", function ($vars) {
        extract(call_user_func($vars["beforeEach"]));

        $result->countSpecs()->willReturn(3);
        $reporter->subscribe($result->reveal());

        expect(array($reporter, "onTestBegin"))
            ->output()->toMatch("/^TAP version 13$/m");
    });

    it("prints a 1 test plan correctly", function ($vars) {
        extract(call_user_func($vars["beforeEach"]));

        $result->countSpecs()->willReturn(1);
        $reporter->subscribe($result->reveal());

        expect(array($reporter, "onTestBegin"))
            ->output()->toMatch("/^1..1$/m");
    });

    it("prints an N test plan correctly", function ($vars) {
        extract(call_user_func($vars["beforeEach"]));

        $result->countSpecs()->willReturn(7);
        $reporter->subscribe($result->reveal());

        expect(array($reporter, "onTestBegin"))
            ->output()->toMatch("/^1..7$/m");
    });

    it("prints 'ok' on a passing test", function ($vars) {
        extract(call_user_func($vars["beforeEach"]));
        $reporter->subscribe($result->reveal());

        $specResult = $prophet->prophesize(SpecResult::className());
        $specResult->title = "message";

        expect(array($reporter, "onSpecPass", $specResult->reveal()))
            ->output()->toMatch("/^ok 1 - message/m");
    });

    it("prints 'not ok' on a failing test", function ($vars) {
        extract(call_user_func($vars["beforeEach"]));

        $specResult = $prophet->prophesize(SpecResult::className());
        $specResult->title = "test";
        $specResult->getMessage()->willReturn("message");

        expect(array($reporter, "onSpecFail", $specResult->reveal()))
            ->output()->toMatch("/^not ok 1 - test: message$/m");
    });

    xit("prints a comment line when starting a new suite", function () {
        $reporter = new TapReporter;
        $prophet = new Prophet;

        $suite = $prophet->prophesize(Suite::className());
        $suite->title = "suite title";

        $result = $prophet->prophesize(TestResult::className());
        $result->on(Argument::cetera())->willReturn(null);
        $result->getCurrentSuite()->willReturn($suite->reveal());
        $reporter->subscribe($result->reveal());

        expect(array($reporter, "onSuiteBegin"))
            ->output()->toMatch("/^# suite title$/m");
    });
});
