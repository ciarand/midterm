<?php

use Ciarand\Midterm\Collection\PermutationCollection;
use Ciarand\Midterm\Spec\Permutation;

describe("a PermutationCollection", function () {
    it("should throw an exception when created w/ invalid data", function () {
        $callback = callback(function () {
            // invalid data
            $data = array((object) array());

            $collection = new PermutationCollection($data);
        });

        expect($callback)->when()->run()->toThrow();
    });

    it("should not throw an exception when created w/ valid data", function () {
        $callback = callback(function () {
            $data = array(new Permutation("title", array("foo")));

            $collection = new PermutationCollection($data);
        });

        expect($callback)->when()->run()->not()->toThrow();
    });

    it("should throw an exception when adding invalid data", function () {
        $callback = callback(function () {
            $data = array((object) array());

            $collection = new PermutationCollection();
            $collection[] = $data;
        });

        expect($callback)->when()->run()->toThrow();
    });

    it("should throw an exception when adding invalid data", function () {
        $callback = callback(function () {
            $data = array(new Permutation("title", array("foo")));

            $collection = new PermutationCollection();
            $collection[] = $data;
        });

        expect($callback)->when()->run()->not()->toThrow();
    });
});
