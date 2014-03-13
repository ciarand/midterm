<?php namespace Ciarand\Midterm\Presenter;

class StringPresenter extends AbstractPresenter
{
    public function present(PresenterInterface $parent, $object)
    {
        return '"' . addslashes($object) . '"';
    }
}
