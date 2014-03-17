<?php

use Ciarand\Midterm\Expectation\AttributeExpectation;

describe("the attribute expectation", function () {
    it("should pass on a correct key() check", function ($key) {
        $expectation = callback(function () use ($key) {
            $arr = array(
                "foo" => "bar",
                "baz" => "idk",
                "hello" => "world",
            );

            $expect = new AttributeExpectation($arr);
            $expect->key($key);
        });

        expect($expectation)->when()->run()->not()->toThrow();
    })->with(
        array("foo"),
        array("baz"),
        array("hello")
    );

    it("should fail on an incorrect key() check", function ($key) {
        $expectation = callback(function () use ($key) {
            $arr = array(
                "foo" => "bar",
                "baz" => "idk",
                "hello" => "world",
            );

            $expect = new AttributeExpectation($arr);
            $expect->key($key);
        });

        expect($expectation)->when()->run()->toThrow();
    })->with(
        array("bar"),
        array("idk"),
        array("world")
    );

    it("should pass on a correct property() check", function ($key) {
        $expectation = callback(function () use ($key) {
            $object = (object) array(
                "foo" => "bar",
                "baz" => "idk",
                "hello" => "world",
            );

            $expect = new AttributeExpectation($object);
            $expect->property($key);
        });

        expect($expectation)->when()->run()->not()->toThrow();
    })->with(
        array("foo"),
        array("baz"),
        array("hello")
    );

    it("should fail on an incorrect property() check", function ($key) {
        $expectation = callback(function () use ($key) {
            $object = (object) array(
                "foo" => "bar",
                "baz" => "idk",
                "hello" => "world",
            );

            $expect = new AttributeExpectation($object);
            $expect->property($key);
        });

        expect($expectation)->when()->run()->toThrow();
    })->with(
        array("bar"),
        array("idk"),
        array("world")
    );

    it("should pass on a correct length() or count() check", function ($count) {
        $expectation = callback(function () use ($count) {
            $arr = array(1, 2, 3, 4, 5);

            $expect = new AttributeExpectation($arr);
            $expect->count($count);
            $expect->length($count);
        });

        expect($expectation)->when()->run()->not()->toThrow();
    })->with(
        array(5)
    );

    it("should fail on an incorrect length() or count() check", function ($count) {
        $expectation = callback(function () use ($count) {
            $arr = array(1, 2, 3, 4, 5);

            $expect = new AttributeExpectation($arr);
            $expect->count($count);
            $expect->length($count);
        });

        expect($expectation)->when()->run()->toThrow();
    })->with(
        array(0),
        array(1),
        array(2),
        array(3),
        array(4),
        array(6),
        array(7)
    );

    it("should pass on a correct element() check", function ($elem) {
        $expectation = callback(function () use ($elem) {
            $arr = array(
                "foo" => "bar",
                "baz" => "idk",
                "hello" => "world",
            );

            $expect = new AttributeExpectation($arr);
            $expect->element($elem);
        });

        expect($expectation)->when()->run()->not()->toThrow();
    })->with(
        array("bar"),
        array("idk"),
        array("world")
    );

    it("should fail on an incorrect element() check", function ($elem) {
        $expectation = callback(function () use ($elem) {
            $arr = array(
                "foo" => "bar",
                "baz" => "idk",
                "hello" => "world",
            );

            $expect = new AttributeExpectation($arr);
            $expect->element($elem);
        });

        expect($expectation)->when()->run()->toThrow();
    })->with(
        array("foo"),
        array("baz"),
        array("hello")
    );
});
