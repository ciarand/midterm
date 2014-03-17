<?php

use Ciarand\Midterm\Collection\SuiteCollection;
use Ciarand\Midterm\Suite;

describe("Suite Collection", function () {
    it("should throw an exception on invalid data", function () {
        $callback = function () {
            $data = array((object) array());
            $collection = new SuiteCollection($data);
        };

        $expected = new Exception(
            sprintf(
                "stdClass is an invalid data type for %s",
                SuiteCollection::className()
            )
        );

        expect($callback)->toThrow($expected)->whenRun();
    });

    it("should allow adding items via array syntax", function () {
        $collection = new SuiteCollection;
        $suite = new Suite("title!");

        $collection[] = $suite;

        expect(count($collection))->toBe(1);
    });
});
