<?php namespace Ciarand\Midterm\Presenter;

use Ciarand\Midterm\BaseComponent;

abstract class AbstractPresenter extends BaseComponent implements
    TypePresenterInterface
{
    abstract public function present(PresenterInterface $parent, $object);
}
