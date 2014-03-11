<?php namespace Ciarand\Midterm\Presenter;

use Traversable;

class RecursivePresenter extends AbstractPresenter
{
    protected $scalarTypes = array(
        "boolean",
        "integer",
        "double",
        "string",
        "NULL",
    );

    protected $booleanPresenter;
    protected $integerPresenter;
    protected $floatPresenter;
    protected $stringPresenter;
    protected $nullPresenter;
    protected $objectPresenter;

    public function __construct()
    {
        $this->booleanPresenter = new BooleanPresenter;
        $this->integerPresenter = new IntegerPresenter;
        $this->floatPresenter   = new FloatPresenter;
        $this->stringPresenter  = new StringPresenter;
        $this->nullPresenter    = new NullPresenter;
        $this->objectPresenter  = new ObjectPresenter;
    }

    public function present($item)
    {
        if (in_array(gettype($item), $this->scalarTypes, true)) {
            return $this->presentScalar($item);
        }

        return $this->presentComplex($item);
    }

    protected function presentScalar($item)
    {
        switch (gettype($item)) {
            case "boolean":
                return $this->booleanPresenter->present($item);
            case "integer":
                return $this->integerPresenter->present($item);
            case "double":
                return $this->floatPresenter->present($item);
            case "string":
                return $this->stringPresenter->present($item);
            case "NULL":
                return $this->nullPresenter->present($item);
        }
    }

    protected function presentComplex($item)
    {
        if (is_array($item) || $item instanceof Traversable) {
            return $this->presentTraversable($item);
        }

        if (is_object($item)) {
            return $this->objectPresenter->present($item);
        }
    }

    protected function presentTraversable($item)
    {
        if (!$this->isAssoc($item)) {
            $mapped = array_map(array($this, "present"), $item);
            return "[" . implode(", ", $mapped) . "]";
        }

        $elems = array();
        $count = 0;

        foreach ($item as $key => $element) {
            if ($key === $count) {
                $elems[] = $this->present($element);
            } else {
                $elems[] = $this->present($key) . " => " . $this->present($element);
            }
            $count += 1;
        }

        return "[" . implode(", ", $elems) . "]";
    }

    protected function isAssoc($array)
    {
        return (bool) count(array_filter(array_keys($array), 'is_string'));
    }
}
