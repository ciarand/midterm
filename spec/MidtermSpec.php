<?php

use Prophecy\Prophet;
use Prophecy\Argument;
use Ciarand\Midterm\Midterm;
use Ciarand\Midterm\Container;
use Ciarand\Midterm\Result\TestResult;
use Ciarand\Midterm\Collection\SuiteCollection;

describe("the Midterm class", function () {
    it("should return the container object it was given", function () {
        $prophet   = new Prophet;
        $mock      = $prophet->prophesize(Container::className());
        $container = $mock->reveal();

        $midterm = new Midterm($container);

        expect($midterm->getContainer())->toBe($container);
    });

    it("should use the container to create things", function () {
        $prophet   = new Prophet;
        $mock      = $prophet->prophesize(Container::className());
        $method = $mock->make(TestResult::className(), Argument::cetera());
        $method->willReturn(new TestResult(new SuiteCollection()));
        $method->shouldBeCalled();

        $midterm = new Midterm($mock->reveal());

        $midterm->go();

        $prophet->checkPredictions();
    });
});
