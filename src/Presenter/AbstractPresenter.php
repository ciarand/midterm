<?php namespace Ciarand\Midterm\Presenter;

abstract class AbstractPresenter implements PresenterInterface
{
    abstract public function present($object);
}
