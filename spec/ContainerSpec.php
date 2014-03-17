<?php

use Ciarand\Midterm\Container;

describe("The Container class", function () {
    it("should be able to bind implementations to interfaces", function () {
        $implementation = "Ciarand\Midterm\Reporter\TapReporter";

        $callback = callback(function () use ($implementation) {
            $container = new Container;
            $interface = "Ciarand\Midterm\Reporter\ReporterInterface";
            $container->bind($interface, $implementation);

            return $container->make($interface);
        });

        expect($callback())->to()->be()->anInstanceOf($implementation);
    });

    it("should be able to bind callable return values", function () {
        $container = new Container;
        $closure = function () {
            return (object) array("foo" => "bar");
        };

        $container->bind("foo", $closure);

        expect($container->make("foo"))->to()->be()->anInstanceOf("stdClass");
    });

    it("should be able to bind sharable objects", function () {
        $container = new Container;
        $shared = (object) array("foo" => "bar");

        $container->share("foo", $shared);

        expect($container->make("foo"))->to()->be()->a($container->make("foo"));
    });

    it("should be able to bind sharable params", function () {
        $container = new Container;

        $container->bind("database_password", "password");

        expect($container->make("database_password"))->to()->be()->a("password");
    });

    it("should pass parameters to objects it makes", function () {
        $container = new Container;

        $container->bind("foo", function ($args) {
            expect($args)->to()->be()->a(array("foo" => "bar"));
        });

        $container->make("foo", array("foo" => "bar"));
    });
});
