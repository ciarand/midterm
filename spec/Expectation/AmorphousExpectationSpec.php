<?php

use Ciarand\Midterm\Expectation\AmorphousExpectation;
use Ciarand\Midterm\Expectation\BehaviorExpectation;
use Ciarand\Midterm\Expectation\PendingExpectation;
use Ciarand\Midterm\Expectation\IdentityExpectation;
use Ciarand\Midterm\Expectation\CallbackExpectation;
use Ciarand\Midterm\Expectation\AttributeExpectation;
use Ciarand\Midterm\Expectation\TypeExpectation;

describe("An amorphous expectation", function () {
    it("should be created through the 'expect' function", function () {
        $actual = expect("foo");
        $class  = AmorphousExpectation::className();

        expect($actual)->to()->be()->anInstanceOf($class);
    });

    it("should create a pending expectation on when()", function () {
        $actual = with(new AmorphousExpectation("foo"))->when();
        $class = PendingExpectation::className();

        expect($actual)->to()->be()->anInstanceOf($class);
    });

    it("should create a behavior expectation on to()", function () {
        $actual = with(new AmorphousExpectation("foo"))->to();
        $class = BehaviorExpectation::className();

        expect($actual)->to()->be()->anInstanceOf($class);
    });

    it("should create an identity expectation on toBe()", function () {
        $actual = with(new AmorphousExpectation("foo"))->toBe();
        $class = IdentityExpectation::className();

        expect($actual)->to()->be()->anInstanceOf($class);
    });

    it("should create a callback expectation on whenRun()", function () {
        $actual = with(new AmorphousExpectation("foo"))->whenRun();
        $class = CallbackExpectation::className();

        expect($actual)->to()->be()->anInstanceOf($class);
    });

    it("should create an attribute expectation on toHave()", function () {
        $actual = with(new AmorphousExpectation("foo"))->toHave();
        $class = AttributeExpectation::className();

        expect($actual)->to()->be()->anInstanceOf($class);
    });

    it("should create a type expectation on as()", function () {
        $actual = with(new AmorphousExpectation("foo"))->as();
        $class = TypeExpectation::className();

        expect($actual)->to()->be()->anInstanceOf($class);
    });

    it("should be negated with not()", function () {
        $expectation = new AmorphousExpectation(true);

        expect($expectation->isNegated())->to()->be()->false();
        $expectation->not();
        expect($expectation->isNegated())->to()->be()->true();
    });
});
