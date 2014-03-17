<?php

use Ciarand\Midterm\CallbackGenerator;
use Ciarand\Midterm\Callback;

describe("the callback generator", function () {
    $generator = new CallbackGenerator;

    it("should package up a closure", function () use ($generator) {
        $wasCalled = false;
        $closure = function () use (&$wasCalled) {
            $wasCalled = true;
        };

        $result = $generator->generate($closure);
        $result();

        expect($wasCalled)->to()->be()->true();
    });

    it("should package up a closure with data", function () use ($generator) {
        $closure = function ($data) {
            return $data;
        };

        $true = $generator->generate($closure, array(true));
        $false = $generator->generate($closure, array(false));

        expect($true())->to()->be()->true();
        expect($false())->to()->be()->false();
    });

    it("should have an alias function, 'callback'", function () {
        $empty = function () {

        };

        expect(callback($empty))->to()->be()->anInstanceOf(Callback::className());
    });
});
