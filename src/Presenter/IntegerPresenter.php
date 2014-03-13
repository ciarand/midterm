<?php namespace Ciarand\Midterm\Presenter;

class IntegerPresenter extends AbstractPresenter
{
    public function present(PresenterInterface $parent, $item)
    {
        return $item;
    }
}
