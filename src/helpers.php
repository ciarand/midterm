<?php

use Ciarand\Midterm\Suite;
use Ciarand\Midterm\SuiteHelper;
use Ciarand\Midterm\GlobalState;
use Ciarand\Midterm\Spec;
use Ciarand\Midterm\Expectation\Expectation;
use Ciarand\Midterm\Exception\CallbackNotCallableException;

/**
 * Creates a new Suite and adds it as the current suite for the context of the
 * callback
 *
 * @param string title
 * @param callable $callback
 */
function describe($title, $callback)
{
    if (!is_callable($callback)) {
        throw new CallbackNotCallableException();
    }

    GlobalState::getMidterm()->addSuite($suite = new Suite($title));

    call_user_func($callback, $suite->helper);
}

/**
 * An easy way of marking specs "do not run" or "not ready yet"
 *
 * @SuppressWarnings(PHPMD.UnusedFormalParameters)
 *
 * @param string $title
 * @param callable $callback
 */
function xdescribe($title, $callback)
{

}

/**
 * Creates a new spec and adds it to the current active Suite
 *
 * @SuppressWarnings(PHPMD.ShortMethodNames)
 *
 * @param string $title
 * @param callable $callback
 */
function it($title, $callback)
{
    if (!is_callable($callback)) {
        throw new CallbackNotCallableException();
    }

    $midterm = GlobalState::getMidterm();

    $midterm->getCurrentSuite()->addSpec(new Spec($title, $callback));
}

/**
 * An easy way of marking specs "do not run" or "not ready yet"
 *
 * @SuppressWarnings(PHPMD.UnusedFormalParameters)
 */
function xit($title, $callback)
{
    // Do nothing
}

/**
 * Creates a new Expectation
 *
 * @param mixed $thing
 * @return Expectation
 */
function expect($thing)
{
    return new Expectation($thing);
}

/**
 * Attaches all the variables stored in the provided SuiteHelper to the current
 * variable scope
 */
function attach(SuiteHelper $helper)
{
    extract($helper->export());
}