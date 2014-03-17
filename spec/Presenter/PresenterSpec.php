<?php

use Ciarand\Midterm\Presenter\PresenterFactory;

describe("ArrayPresenter", function () {
    it("prints values correctly", function ($arr, $expectation) {
        $callback = callback(function () use ($arr) {
            $presenter = with(new PresenterFactory)->present($arr);
        });

        expect($callback())->to()->be($expectation);
    })->with(
        data(array(), "[]"),
        data(array(1, 2, 3), "[1, 2, 3]"),
        data(array(2, 3, 4), "[2, 3, 4]"),
        data(array(4, 5, 6), "[4, 5, 6]"),
        data(array("foo", "bar", "baz"), '["foo", "bar", "baz"]'),
        data(array("foo", array()), '["foo", []]'),
        data(array(array(), "foo"), '[[], "foo"]'),
        data(array(array(), array()), '[[], []]'),
        data(array("foo" => "bar"), '["foo" => "bar"]'),
        data(array("foo" => "bar", "baz"), '["foo" => "bar", 0 => "baz"]'),
        data(array("baz", "foo" => "bar"), '[0 => "baz", "foo" => "bar"]'),
        data("foo", '"foo"'),
        data(1, 1),
        data("1", '"1"'),
        data(null, "NULL"),
        data(12.10, 12.10),
        data(pi(), pi()),
        data(null, "NULL"),
        data(null, "NULL"),
        data(null, "NULL"),
        data('in "quotes"', '"in \"quotes\""')
    );
});
