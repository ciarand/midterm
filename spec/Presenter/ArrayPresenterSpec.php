<?php

use Ciarand\Midterm\Presenter\ArrayPresenter;

describe("ArrayPresenter", function () {
    it("prints an empty array correctly", function () use ($presenter) {
        $presenter = new ArrayPresenter;

        expect(array($presenter, "present", array()))->toReturn("[]");
    });

    it("prints arrays correctly", function ($arr, $expectation) {
        $presenter = new ArrayPresenter;

        expect(array($presenter, "present", $arr))->toReturn($expectation);
    })->with(
        array(array(1, 2, 3), "[1, 2, 3]"),
        array(array(2, 3, 4), "[2, 3, 4]"),
        array(array(4, 5, 6), "[4, 5, 6]"),
        array(array("foo", "bar", "baz"), '["foo", "bar", "baz"]'),
        array(array("foo", array()), '["foo", []]'),
        array(array(array(), "foo"), '[[], "foo"]'),
        array(array(array(), array()), '[[], []]'),
        array(array("foo" => "bar"), '["foo" => "bar"]'),
        array(array("foo" => "bar", "baz"), '["foo" => "bar", "baz"]'),
        array(array("baz", "foo" => "bar"), '["baz", "foo" => "bar"]')
    );
});
