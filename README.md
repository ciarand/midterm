This project is deprecated and unmaintained. Proceed with caution!

Midterm
=======
>A lightweight, BDD-style testing framework for PHP

[![Build Status][badge]][travis]

[badge]: https://travis-ci.org/ciarand/midterm.png
[travis]: https://travis-ci.org/ciarand/midterm

Midterm aims to be a simple and intuitive testing framework for BDD-style
testing. It began as an experiment in API design and has evolved into a
full-fledged framework.

Philosophy
----------
The goal of Midterm is to be a well tested, stable framework that can be used on
any project regardless of its complexity.

Interface
---------
Many PHP tools available rely heavily on global state to both bootstrap
themselves and provide easy access to important objects.

Some global state (read: static class variables) is an inevitable requirement
for object-less functions to form a cohesive, yet succinct API. However, the
interface to Midterm stays as independent and loosely coupled as is feasible. As
a result, the library can be included in any build system without shelling out
to the console for a new command.

PHP Support
-----------
Midterm is [tested][travis] against 5.3, 5.4, 5.5, and 5.6. It currently fails
against HHVM because of some missing functionality related to dynamic code
execution. The plan is to support all platforms, including HHVM, by a 1.0
release.

Versioning
----------
Midterm uses and supports [semantic versioning][semver]. Since we are not yet at
a 1.0 release, that means the API should be considered unstable and that
anything can and will change.

>Major version zero (0.y.z) is for initial development. Anything may change at
>any time. The public API should not be considered stable.

[semver]: http://semver.org/

Inspirations
------------
This project is heavily inspired by [Pho][] and its elegant API design. The
concept began as a fork of Pho to support older versions of PHP.

[Pho]: https://github.com/danielstjules/pho

License
-------
MIT, see the [license file][license].

[license]: /LICENSE
