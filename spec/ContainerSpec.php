<?php

use Ciarand\Midterm\Container;

describe("The Container class", function () {
    it("should be able to bind implementations to interfaces", function () {
        $container = new Container;
        $interface = "Ciarand\Midterm\Reporter\ReporterInterface";
        $implementation = "Ciarand\Midterm\Reporter\TapReporter";
        $container->bind($interface, $implementation);

        expect($container->make($interface))->toBeAnInstanceOf($implementation);
    });

    it("should be able to bind callable return values", function () {
        $container = new Container;
        $closure = function () {
            return (object) array("foo" => "bar");
        };

        $container->bind("foo", $closure);

        expect($container->make("foo"))->toBeAnInstanceOf("stdClass");
    });

    it("should be able to bind sharable objects", function () {
        $container = new Container;
        $shared = (object) array("foo" => "bar");

        $container->share("foo", $shared);

        expect($container->make("foo"))->toBe($container->make("foo"));
    });

    it("should be able to bind sharable params", function () {
        $container = new Container;

        $container->bind("database_password", "password");

        expect($container->make("database_password"))->toBe("password");
    });

    it("should pass parameters to objects it makes", function () {
        $container = new Container;

        $container->bind("foo", function ($args) {
            expect($args)->toBe(array("foo" => "bar"));
        });

        $container->make("foo", array("foo" => "bar"));
    });
});
