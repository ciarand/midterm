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
        data("foo"),
        data("baz"),
        data("hello")
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
        data("bar"),
        data("idk"),
        data("world")
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
        data("foo"),
        data("baz"),
        data("hello")
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
        data("bar"),
        data("idk"),
        data("world")
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
        data(5)
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
        data(0),
        data(1),
        data(2),
        data(3),
        data(4),
        data(6),
        data(7)
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
        data("bar"),
        data("idk"),
        data("world")
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
        data("foo"),
        data("baz"),
        data("hello")
    );
});
