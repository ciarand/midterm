<?php namespace Ciarand\Midterm\Result;

use Exception;
use Ciarand\Midterm\BaseComponent;

/**
 * A SpecResult represents the result of a spec, and is primarily evaluated by
 * reporters to display the spec status
 */
class SpecResult extends BaseComponent
{
    /**
     * Indicates the spec failed
     */
    const DID_FAIL = 1;

    /**
     * Indicates the spec passed
     */
    const DID_PASS = 2;

    /**
     * Indicates the spec was skipped
     */
    const DID_SKIP = 4;

    /**
     * @var Exception
     */
    public $exception;

    /**
     * @var string
     */
    public $title;

    /**
     * @var int
     */
    protected $status;

    /**
     * Creates a new spec result with the given title and status
     *
     * @param string $title
     * @param int $status
     */
    public function __construct($title, $status = self::DID_PASS)
    {
        if (!is_int($status)) {
            throw new InvalidArgumentException(
                "{$status} is not a valid result status"
            );
        }

        $this->title = $title;
        $this->status = $status;
    }

    /**
     * Returns whether the test failed
     *
     * @return boolean
     */
    public function didFail()
    {
        return (bool) ($this->status & static::DID_FAIL);
    }

    /**
     * Returns whether the test passed
     *
     * @return boolean
     */
    public function didPass()
    {
        return (bool) ($this->status & static::DID_PASS);
    }

    /**
     * Returns whether the test was skipped
     *
     * @return boolean
     */
    public function didSkip()
    {
        return (bool) ($this->status & static::DID_SKIP);
    }

    /**
     * Gets the message, if any, associated with the test failure
     *
     * @return null|string
     */
    public function getMessage()
    {
        if ($this->exception instanceof Exception) {
            return $this->exception->getMessage();
        }

        return null;
    }
}
