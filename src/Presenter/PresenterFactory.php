<?php namespace Ciarand\Midterm\Presenter;

use Traversable;
use Exception;

class PresenterFactory implements PresenterInterface
{
    protected $presenters = array();

    public function present($object)
    {
        $method = "present" . ucfirst(strtolower(gettype($object)));

        if (method_exists($this, $method)) {
            return $this->$method($object);
        }

        if (is_array($object) || $object instanceof Traversable) {
            return $this->presentTraversable($object);
        }

        throw new Exception("Don't know how to present this thing");
    }

    public function presentBoolean($object)
    {
        return $this->presentWith($object, BooleanPresenter::className());
    }

    public function presentInteger($object)
    {
        return $this->presentWith($object, IntegerPresenter::className());
    }

    public function presentDouble($object)
    {
        return $this->presentFloat($object);
    }

    public function presentFloat($object)
    {
        return $this->presentWith($object, FloatPresenter::className());
    }

    public function presentString($object)
    {
        return $this->presentWith($object, StringPresenter::className());
    }

    public function presentNull($object)
    {
        return $this->presentWith($object, NullPresenter::className());
    }

    public function presentTraversable($object)
    {
        return $this->presentWith($object, TraversablePresenter::className());
    }

    public function presentObject($object)
    {
        return $this->presentWith($object, ObjectPresenter::className());
    }

    protected function getPresenter($name)
    {
        if (!isset($this->presenters[$name])) {
            $this->presenters[$name] = new $name;
        }

        return $this->presenters[$name];
    }

    protected function presentWith($object, $name)
    {
        $presenter = $this->getPresenter($name);

        return $presenter->present($this, $object);
    }
}
