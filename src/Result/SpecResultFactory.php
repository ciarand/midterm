<?php namespace Ciarand\Midterm\Result;

use Exception;
use Ciarand\Midterm\BaseComponent;

class SpecResultFactory extends BaseComponent
{
    public function pass($title)
    {
        return new SpecResult($title, SpecResult::DID_PASS);
    }

    public function failWithException($title, Exception $exception)
    {
        $spec = new SpecResult($title, SpecResult::DID_FAIL);

        $spec->exception = $exception;

        return $spec;
    }

    /**
     * @param string $title
     * @param Exception $exception
     */
    public function skipWithException($title, $exception)
    {
        $spec = new SpecResult($title, SpecResult::DID_SKIP);

        $spec->exception = $exception;

        return $spec;
    }
}
