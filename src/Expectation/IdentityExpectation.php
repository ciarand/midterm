<?php namespace Ciarand\Midterm\Expectation;

class IdentityExpectation extends AbstractExpectation
{
    /**
     * @SuppressWarnings(PHPMD.ShortMethodNames)
     */
    public function a($expected)
    {
        $got = $this->actual;

        $this->message = sprintf(
            "%s was not strictly equal to %s",
            is_object($got) ? get_class($got) : gettype($got),
            is_object($expected) ? get_class($expected) : gettype($expected)
        );

        $this->check($this->actual === $expected);
    }

    /**
     * @SuppressWarnings(PHPMD.ShortMethodNames)
     */
    public function an($expected)
    {
        return $this->a($expected);
    }

    public function anInstanceOf($class)
    {
        $got = $this->actual;

        $this->message = sprintf(
            "%s was not an instanceof %s",
            is_object($got) ? get_class($got) : gettype($got),
            $class
        );

        $this->check($this->actual instanceof $class);
    }

    public function equalTo($expected)
    {
        $this->check($this->actual == $expected);
    }

    public function greaterThan($expected)
    {
        $this->check($this->actual > $expected);
    }

    public function lessThan($expected)
    {
        $this->check($this->actual < $expected);
    }

    public function withinRange($min, $max)
    {
        $this->check($min <= $this->actual && $this->actual <= $max);
    }

    public function true()
    {
        $this->message = sprintf(
            "Expected %s to be %s",
            $this->castPrimitiveToString($this->actual),
            $this->castPrimitiveToString(true)
        );

        $this->check($this->actual === true);
    }

    public function false()
    {
        $this->message = sprintf(
            "Expected %s to be %s",
            $this->castPrimitiveToString($this->actual),
            $this->castPrimitiveToString(null)
        );

        $this->check($this->actual === false);
    }

    public function null()
    {
        $this->message = sprintf(
            "Expected %s to be %s",
            $this->castPrimitiveToString($this->actual),
            $this->castPrimitiveToString(null)
        );

        $this->check($this->actual === null);
    }

    protected function castPrimitiveToString($primitive)
    {
        switch (gettype($primitive)) {
            case "boolean":
                return $primitive ? "true" : "false";

            case "NULL":
                return "null";

            default:
                return (string) $primitive;
        }
    }
}
