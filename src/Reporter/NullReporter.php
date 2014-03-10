<?php namespace Ciarand\Midterm\Reporter;

use Ciarand\Midterm\BaseComponent;
use Ciarand\Midterm\Result\TestResult;

class NullReporter extends BaseComponent implements ReporterInterface
{
    /**
     * @var resource
     */
    protected $output;

    /**
     * @var TestResult
     */
    protected $result;

    /**
     * Creates a new instance that will report to the provided output
     *
     * @param string $output
     */
    public function __construct($output = "php://output")
    {
        if (!is_resource($output)) {
            return $this->output = fopen($output, "w");
        }

        $this->output = $output;
    }

    /**
     * @param TestResult $result
     */
    public function subscribe(TestResult $result)
    {
        $this->result = $result;

        foreach ($this->getSubscriptions() as $event => $listener) {
            $result->on($event, $listener);
        }
    }

    /**
     * Writes a message to the output resource. Accepts the same parameters as
     * printf and sprintf.
     *
     * @param string $message
     * @param mixed $args...
     */
    protected function write($message)
    {
        $message = count($args = func_get_args()) > 1
            ? call_user_func_array("sprintf", $args)
            : $message;

        fwrite($this->output, $message);
    }

    /**
     * @return array
     */
    protected function getSubscriptions()
    {
        return array();
    }
}
