<?php namespace Ciarand\Midterm;

use Exception;
use ArrayAccess;
use Ciarand\Midterm\Exception\SpecFailedException;
use Ciarand\Midterm\Exception\SpecSkippedException;
use Ciarand\Midterm\Result\SpecResultFactory;

class Spec extends BaseComponent
{
    /**
     * @var string
     */
    public $title;

    /**
     * @var callable
     */
    protected $callback;

    /**
     * @param string $title
     * @param callable $callback
     */
    public function __construct($title, $callback)
    {
        $this->title = $title;
        $this->callback = $callback;
    }

    /**
     * @param SuiteHelper $helper
     * @return SpecResult
     */
    public function run(SuiteHelper $helper)
    {
        $factory = new SpecResultFactory;

        $helper->on("fail", array($this, "fail"));
        $helper->on("skip", array($this, "skip"));

        try {
            if (method_exists($this->callback, "bindTo")) {
                $this->callback->bindTo($helper);
            }

            ob_start();
            call_user_func($this->callback, $helper);
            ob_end_clean();

            return $factory->pass($this->title);
        } catch (SpecSkippedException $e) {
            return $factory->skipWithException($this->title, $e);
        } catch (Exception $e) {
            return $factory->failWithException($this->title, $e);
        }
    }

    /**
     * Throws a new SpecFailedException, which causes the Spec to fail if run
     * within the callback
     *
     * @param string $message
     */
    public function fail($message)
    {
        throw new SpecFailedException($message);
    }

    public function skip($message)
    {
        throw new SpecSkippedException($message);
    }
}
