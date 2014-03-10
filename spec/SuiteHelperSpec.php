<?php

use Ciarand\Midterm\SuiteHelper;

describe("SuiteHelper", function ($vars) {
    $vars->inject(get_defined_vars());

    it("should export and import correctly", function () {
        $helper = new SuiteHelper;

        $helper->inject(array("foo" => "bar"));

        expect($helper->export())->toBe(array("foo" => "bar"));
    });

    it("should implement count correctly", function () {
        $helper = new SuiteHelper;

        $helper->inject(array("foo" => "bar", "baz" => "idk"));

        expect(count($helper))->toBe(2);
    });

    it("should propagate a fail event", function () {
        $helper    = new SuiteHelper;
        $message   = "foo bar baz!";
        $wasCalled = false;

        $helper->on("fail", function ($actual) use ($message, $wasCalled) {
            expect($actual)->toBe($message);

            $wasCalled = true;
        });

        $helper->fail($message);

        expect($wasCalled)->toBe(true);
    });

    it("should propagate a skip event", function () {
        $helper    = new SuiteHelper;
        $message   = "foo bar";
        $wasCalled = false;

        $helper->on("skip", function ($actual) use ($message, $wasCalled) {
            expect($actual)->toBe($message);

            $wasCalled = true;
        });

        $helper->skip($message);

        expect($wasCalled)->toBe(true);
    });

    it("should implement arrayaccess correctly", function () {
        $helper = new SuiteHelper;
        $helper["foo"] = "bar";

        expect($helper["foo"])->toBe("bar");

        unset($helper["foo"]);

        expect(isset($helper["foo"]))->toBe(false);
    });
});
