<?php

use Ciarand\Midterm\Presenter\PresenterFactory;

describe("ArrayPresenter", function () {
    it("prints values correctly", function ($arr, $expectation) {
        $callback = callback(function () use ($arr) {
            $presenter = with(new PresenterFactory)->present($arr);
        });

        expect($callback())->to()->be($expectation);
    })->with(
        array(array(), "[]"),
        array(array(1, 2, 3), "[1, 2, 3]"),
        array(array(2, 3, 4), "[2, 3, 4]"),
        array(array(4, 5, 6), "[4, 5, 6]"),
        array(array("foo", "bar", "baz"), '["foo", "bar", "baz"]'),
        array(array("foo", array()), '["foo", []]'),
        array(array(array(), "foo"), '[[], "foo"]'),
        array(array(array(), array()), '[[], []]'),
        array(array("foo" => "bar"), '["foo" => "bar"]'),
        array(array("foo" => "bar", "baz"), '["foo" => "bar", 0 => "baz"]'),
        array(array("baz", "foo" => "bar"), '[0 => "baz", "foo" => "bar"]'),
        array("foo", '"foo"'),
        array(1, 1),
        array("1", '"1"'),
        array(null, "NULL"),
        array(12.10, 12.10),
        array(pi(), pi()),
        array(null, "NULL"),
        array(null, "NULL"),
        array(null, "NULL"),
        array('in "quotes"', '"in \"quotes\""')
    );
});
